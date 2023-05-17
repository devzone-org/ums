<?php


namespace Devzone\UserManagement\Http\Livewire;


use App\Models\User;
use Devzone\Ams\Model\ChartOfAccount;
use Devzone\UserManagement\Models\UserAdditionalDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $user = [];
    public $user_details = [];
    public $coa = [];
    public $photo;
    public $success;

    protected function rules()
    {
        if (empty($this->user['attachment']) || !empty($this->photo)) {
            return [
                'user.name' => 'required',
                'photo' => 'image|max:1024|dimensions:min_width=100,min_height=100'
            ];
        } else {
            return [
                'user.name' => 'required',
            ];
        }
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024|dimensions:min_width=100,min_height=100', // 1MB Max
        ]);
    }

    public function mount()
    {
        $this->user = Auth::user()->toArray();

        if (env('UMS_BOOTSTRAP') == 'true')
        {
            $this->user_details = UserAdditionalDetail::find($this->user['id']);
            if (empty($this->user_details)) {
                $this->user_details ['first_name'] = $this->user['name'];
                $this->user_details ['family_name'] = $this->user['father_name'];
            } else {
                $this->user_details = $this->user_details->toArray();
            }
        }
    }

    public function render()
    {
        return view('ums::livewire.profile');
    }

    public function updateUser()
    {
        $this->validate();
        try {
            if (!empty($this->photo) && auth()->user()->can('1.edit-profile-photo')) {
                $this->user['attachment'] = $this->photo->storePublicly(env('AWS_FOLDER') . 'profile', 's3');
            }

            User::find($this->user['id'])->update([
                'attachment' => $this->user['attachment'],
                'name' => $this->user['name'],
                'father_name' => $this->user['father_name'],
            ]);

            $this->success = "Profile has been updated.";
        } catch (\Exception $ex) {
            $this->addError('error', $ex->getMessage());
        }
    }

    public function updateUserDetails()
    {
        if (empty($this->user['attachment']) || !empty($this->photo)) {
            $this->validate([
                'user_details.first_name' => 'required',
                'photo' => 'image|max:1024|dimensions:min_width=100,min_height=100'
            ]);
        } else {
            $this->validate([
                'user_details.first_name' => 'required'
            ]);
        }

        try {
            if (!empty($this->photo) && auth()->user()->can('1.edit-profile-photo')) {
                $this->user['attachment'] = $this->photo->storePublicly(env('AWS_FOLDER') . 'profile', 's3');
            }

            if (auth()->user()->can('1.edit-profile-photo'))
            {
                User::find($this->user['id'])->update([
                    'attachment' => $this->user['attachment'],
                ]);
            }

            $found = UserAdditionalDetail::find($this->user['id']);

            if (!empty($found)) {
                $found->update($this->user_details);
            } else {
                $this->user_details['user_id'] = $this->user['id'];
                UserAdditionalDetail::create($this->user_details);
            }

            $this->success = "Profile has been updated.";
        } catch (\Exception $ex) {
            $this->addError('error', $ex->getMessage());
        }
    }
}
