<?php


namespace Devzone\UserManagement\Http\Livewire;


use App\Models\User;
use Devzone\Ams\Model\ChartOfAccount;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $user = [];
    public $coa = [];
    public $photo;
    public $success;

    protected $rules = [
        'user.name' => 'required',
        'photo' => 'image|max:1024|dimensions:min_width=100,min_height=100'
    ];


    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024|dimensions:min_width=100,min_height=100', // 1MB Max
        ]);
    }

    public function mount()
    {
        $this->user = Auth::user()->toArray();
    }

    public function render()
    {
        return view('ums::livewire.profile');
    }


    public function updateUser()
    {
        $this->validate();
        if (!empty($this->photo)) {
            $this->user['attachment'] = $this->photo->storePublicly(env('AWS_FOLDER') . 'profile', 's3');
        }

        User::find($this->user['id'])->update([
            'attachment' => $this->user['attachment'],
            'name' => $this->user['name']
        ]);

        $this->success = "Profile has been updated.";
    }
}
