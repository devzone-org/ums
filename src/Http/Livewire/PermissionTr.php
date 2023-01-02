<?php

namespace Devzone\UserManagement\Http\Livewire;

use Livewire\Component;

class PermissionTr extends Component
{

    public $s;
    public $user;
    public $sr;

    public function mount($permission, $user, $sr)
    {
        $this->s = $permission;
        $this->user = $user;
        $this->sr = $sr;
    }

    public function assign($name)
    {
        $this->user->givePermissionTo($name);
    }


    public function revoke($name)
    {
        $this->user->revokePermissionTo($name);
    }

    public function render()
    {
        return view('ums::livewire.permission-tr');
    }

}