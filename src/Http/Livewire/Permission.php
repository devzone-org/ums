<?php


namespace Devzone\UserManagement\Http\Livewire;


use App\Models\User;
use Livewire\Component;

class Permission extends Component
{

    public $success;
    public $user_id;
    public $user;
    public $permissions = [];
    public $keyword;


    public function mount($id)
    {
        $this->user_id = $id;
        $this->user = User::find($id);
        $this->permissions = \Spatie\Permission\Models\Permission::get()->toArray();
    }

    public function render()
    {
        return view('ums::livewire.permissions');
    }

    public function updatedKeyword($value)
    {

        $this->permissions = \Spatie\Permission\Models\Permission::when(!empty($value),function($q) use ($value) {

                    return $q->orWhere('name','LIKE','%'.$value.'%')->orWhere('section','LIKE','%'.$value.'%')->orWhere('portal','LIKE','%'.$value.'%');

        })->get()->toArray();

    }

    public function assign($name)
    {
        $this->user->givePermissionTo($name);
    }



    public function revoke($name)
    {
        $this->user->revokePermissionTo($name);
    }

}
