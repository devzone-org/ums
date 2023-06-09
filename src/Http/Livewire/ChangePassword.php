<?php


namespace Devzone\UserManagement\Http\Livewire;


use App\Models\User;
use Devzone\Ams\Model\ChartOfAccount;
use Devzone\UserManagement\Traits\LogActivityManualTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    use LogActivityManualTrait;

    public $current_password;
    public $password;
    public $password_confirmation;
    public $success;

    protected $rules = [
        'password' => 'required|confirmed|min:6',
        'current_password' => 'required'
    ];

    public function render()
    {
        return view('ums::livewire.change-password');
    }

    public function changePassword()
    {
        $this->validate();
        try {
            $user = Auth::user();
            if (Hash::check($this->current_password, $user['password'])) {
                User::find($user['id'])->update([
                    'password' => Hash::make($this->password)
                ]);

                $this->success = 'Password has been updated.';

                $description = $this->success;
                $this->auditLog(User::find($user['id']), $user['id'], 'UMS', $description);

                $this->reset(['password', 'current_password', 'password_confirmation']);
            }
            else{
                throw new \Exception('The current password is not correct.');
            }
        } catch (\Exception $ex) {
            $this->addError('error', $ex->getMessage());
        }

    }

}
