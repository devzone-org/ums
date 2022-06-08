<?php


namespace Devzone\UserManagement\Http\Livewire;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditUser extends Component
{
    public $password;
    public $name;
    public $email;
    public $password_confirmation;
    public $success;
    public $status;
    public $primary_id;

    protected $rules = [
        'email' => 'required',
        'name' => 'required',

    ];


    protected $validationAttributes = [
        'email' => 'Email',
        'name' => 'Name',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password'
    ];

    public function mount($id)
    {
        $this->primary_id = $id;
        $user = User::find($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->status = $user->status;

    }

    public function render()
    {
        return view('ums::livewire.edit-user');
    }

    public function addUser()
    {
        $this->validate();

        if (User::where('email', $this->email)->where('id', '!=', $this->primary_id)->exists()) {
            $this->addError('email', 'This email already in use.');
        } else {
            User::find($this->primary_id)->update([
                'email' => $this->email,
                'name' => $this->name,
                'status' => $this->status,
            ]);
            $this->success = 'User has been edited.';
        }

    }

    public function editPass()
    {
        $this->validate([
            'password' => 'min:6',
            'password_confirmation' => 'required_with:password|same:password'
            ]);

        User::find($this->primary_id)
            ->update([
                'password' => Hash::make($this->password)
            ]);

        $this->success = 'Password has been updated.';
        $this->reset(['password', 'password_confirmation']);
    }


}
