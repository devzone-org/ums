<?php

namespace Devzone\UserManagement\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Devzone\UserManagement\Traits\LogActivityManualTrait;

class Google2fa extends Component
{
    use LogActivityManualTrait;

    public $google2fa = null;
    public $success = null;

    protected $rules = [
        'google2fa' => 'required',
    ];

    protected $validationAttributes = [
        'google2fa' => 'Google2fa Enabled?',
    ];

    public function mount()
    {
        $this->google2fa = auth()->user()['2fa'];
    }

    public function update2fa()
    {
        $this->success = null;
        $this->resetErrorBag();
        $this->validate();

        try {

            if (!auth()->user()->can('1.google-2fa-enable')){
                throw new \Exception("You don't have the permission to perform this action");
            }

            User::find(auth()->user()->id)->update([
                '2fa' => $this->google2fa
            ]);

            $this->success = '2FA updated successfully.';

//            $description = $this->success;
//            $this->auditLog(User::find(auth()->user()->id), auth()->user()->id, 'UMS', $description);

        } catch (\Exception $e) {
            $this->addError('error', $e->getMessage());
        }
    }

    public function render()
    {

        return view('ums::livewire.google2fa');
    }

}