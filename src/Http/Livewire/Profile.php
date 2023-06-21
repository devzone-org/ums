<?php


namespace Devzone\UserManagement\Http\Livewire;


use App\Models\User;
use Devzone\UserManagement\Models\UserAdditionalDetail;
use Devzone\UserManagement\Traits\LogActivityManualTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads, LogActivityManualTrait;

    public $user = [];
    public $user_details = [];
    public $old_data = [];
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
            $this->old_data = $this->user_details;
        }else{
            $this->old_data = $this->user;
        }
    }

    public function render()
    {
        return view('ums::livewire.profile');
    }

    public function updateUser()
    {
        $this->validate();
        $temp_desc = '';
        try {
            if (!empty($this->photo) && auth()->user()->can('1.edit-profile-photo')) {
                $this->user['attachment'] = $this->photo->storePublicly(env('AWS_FOLDER') . 'profile', 's3');
            }

            User::find($this->user['id'])->update([
                'attachment' => $this->user['attachment'],
                'name' => $this->user['name'],
                'father_name' => $this->user['father_name'],
            ]);

            if ($this->user['attachment'] != $this->old_data['attachment'])
            {
                $temp_desc = ' User profile photo was updated.';
            }

            unset($this->user['attachment'], $this->old_data['attachment']);

            $description = $this->logDescription($this->user, $this->old_data);

            if (!empty($temp_desc))
            {
                $description = $description . $temp_desc;
            }

            $this->auditLog(User::find($this->user['id']), $this->user['id'], 'UMS', $description);

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

        $temp_desc = '';

        try {
            if (!empty($this->photo) && auth()->user()->can('1.edit-profile-photo')) {
                $this->user['attachment'] = $this->photo->storePublicly(env('AWS_FOLDER') . 'profile', 's3');
            }

            if (auth()->user()->can('1.edit-profile-photo'))
            {
                if (!empty($this->photo))
                {
                    User::find($this->user['id'])->update([
                        'attachment' => $this->user['attachment'],
                    ]);
                    $temp_desc = ' User profile photo was updated.';
//                    $this->auditLog(User::find($this->user['id']), $this->user['id'], 'UMS', $temp_desc);
                }

            }

            $found = UserAdditionalDetail::where('user_id', $this->user['id'])->first();

            if (!empty($found)) {
                UserAdditionalDetail::find($found['id'])->update($this->user_details);
            } else {
                $this->user_details['user_id'] = $this->user['id'];
                UserAdditionalDetail::create($this->user_details);
            }

            $description = $this->logDescription($this->user_details, $this->old_data);
            if (!empty($temp_desc))
            {
                $description = $description . $temp_desc;
            }
            $this->auditLog(UserAdditionalDetail::find($found['id']), $this->user['id'], 'UMS', $description);

            $this->success = "Profile has been updated.";
        } catch (\Exception $ex) {
            $this->addError('error', $ex->getMessage());
        }
    }

}
