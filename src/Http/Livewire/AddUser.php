<?php


namespace Devzone\UserManagement\Http\Livewire;


use App\Models\User;

use Devzone\UserManagement\Traits\LogActivityManualTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AddUser extends Component
{
    use LogActivityManualTrait;

    public $password;
    public $name;
    public $email;
    public $password_confirmation;
    public $father_name;
    public $success;
    public $status;

    protected $rules = [
        'email' => 'required|unique:App\Models\User,email',
        'password' => 'required|min:6',
        'password_confirmation' => 'required_with:password|same:password',
        'name' => 'required'
    ];

    public function render()
    {
        return view('ums::livewire.add-user');
    }

    public function addUser()
    {
        $this->validate();
        $user = User::create([
            'name' => $this->name,
            'father_name' => $this->father_name,
            'email' => $this->email,
            'status' => $this->status,
            'type' => 'admin',
            'password' => Hash::make($this->password)
        ]);

        $description = 'The user has been added.';
        $this->auditLog($user, $user->id, 'UMS', $description);

        $this->success = 'User has been created.';
        $this->reset(['name', 'email', 'status', 'password', 'password_confirmation', 'father_name']);
    }

}
