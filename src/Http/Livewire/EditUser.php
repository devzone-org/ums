<?php


namespace Devzone\UserManagement\Http\Livewire;


use App\Models\User;
use Devzone\UserManagement\Traits\LogActivityManualTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditUser extends Component
{
    use LogActivityManualTrait;

    public $password;
    public $name;
    public $email;
    public $password_confirmation;
    public $success;
    public $status;
    public $primary_id;
    public $old_data;

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

        $this->old_data = [
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status
        ];

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

            $new_data = [
                'name' => $this->name,
                'email' => $this->email,
                'status' => $this->status
            ];

            $description = $this->logDescription($new_data, $this->old_data);
            $this->auditLog(User::find($this->primary_id), $this->primary_id, 'UMS', $description);

            $this->success = 'User has been edited.';
        }

    }

    public function editPass()
    {
        $this->validate([
            'password' => 'min:6',
            'password_confirmation' => 'required_with:password|same:password'
            ]);

        if(auth()->user()->can('1.change-users-passwords'))
        {
            User::find($this->primary_id)->update([
                'password' => Hash::make($this->password)
            ]);

            $description = 'Password has been updated.';
            $this->auditLog(User::find($this->primary_id), $this->primary_id, 'UMS', $description);

            $this->success = 'Password has been updated.';
        }

        $this->reset(['password', 'password_confirmation']);
    }

}
