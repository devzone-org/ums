<?php


namespace Devzone\UserManagement\Http\Livewire;


use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class Users extends Component
{
    public $success;
    public $status = 't';
    public $email;
    public $name;
    public $users;

    protected $rules = [
        'email' => 'required|unique:users.email',
        'password' => 'required|confirmed|min:6',
        'current_password' => 'required'
    ];

    public function render()
    {
       $this->search();
        return view('ums::livewire.users');
    }

    public function search(){

        $this->users = User::where(function ($q){
            return $q->whereNull('type')->orwhereIn('type',['admin','']);
        })->when(!empty($this->status),function ($q){
            return $q->where('status', $this->status);
        })->when(!empty($this->email),function ($q){
            return $q->where('email', $this->email);
        })->when(!empty($this->name),function ($q){
            return $q->where('name', 'LIKE' , '%' . $this->name . '%');
        })
            ->get();

    }
    public function clear(){

        $this->reset(['status','email','name']);
    }

    public function linkToAccounts($id)
    {
        try {
            $user = User::find($id);
            if (!empty($user->account_id)) {
                throw new \Exception('Account already exists');
            }

            if (!auth()->user()->can('1.user.link-accounts')) {
                throw new \Exception(env('PERMISSION_ERROR'));
            }

            DB::beginTransaction();
            $code = \Devzone\Ams\Helper\Voucher::instance()->coa()->get();
            $code = str_pad($code, 7, "0", STR_PAD_LEFT);
            $parent = \Devzone\Ams\Models\ChartOfAccount::where('reference', 'cash-in-hand-4')->first();
            if (empty($parent)) {
                throw new \Exception('Parent account not found.');
            }
            $account_id = \Devzone\Ams\Models\ChartOfAccount::create([
                'name' => 'Cash in Hand - ' . $user->name,
                'type' => $parent->type,
                'sub_account' => $parent->id,
                'level' => 5,
                'code' => $code,
                'nature' => $parent->nature,
                'status' => 't'
            ])->id;

            $user->update([
                'account_id' => $account_id,
                'account_name' => 'Cash in Hand - ' . $user->name
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('error',$e->getMessage());
        }
    }


}
