<?php

namespace Devzone\UserManagement\Http\Livewire;

use App\Models\Permission;
use App\Models\User;
use Devzone\UserManagement\Traits\LogActivityManualTrait;
use Livewire\Component;

class PermissionDetail extends Component
{
    use LogActivityManualTrait;

    public $permission;
    public $assigned_users = [];
    public $unassigned_users = [];

    public $success;
    public $status = 't';
    public $email;
    public $name;

    public function mount($id)
    {
        $this->permission = \Spatie\Permission\Models\Permission::find($id);
    }

    public function search()
    {
        $this->assigned_users = [];
        $this->unassigned_users = [];
        $users = User::where(function ($q) {
            return $q->whereNull('type')->orwhereIn('type', ['admin', '']);
        })->when(!empty($this->status), function ($q) {
            return $q->where('status', $this->status);
        })->when(!empty($this->email), function ($q) {
            return $q->where('email', $this->email);
        })->when(!empty($this->name), function ($q) {
            return $q->where('name', 'LIKE', '%' . $this->name . '%');
        })->get();

        foreach ($users as $u) {
            if ($u->hasPermissionTo($this->permission['name'])) {
                $this->assigned_users[] = $u->toArray();
            } else {
                $this->unassigned_users[] = $u->toArray();
            }
        }
    }


    public function assign($id)
    {
        $assign = User::find($id);
        $assign->givePermissionTo($this->permission['name']);

        $description = '"' . ucwords($this->permission['description']) . '" permission has been assigned.';
        $this->auditLog($assign, $id, 'UMS', $description);
    }

    public function revoke($id)
    {
        $revoke = User::find($id);
        $revoke->revokePermissionTo($this->permission['name']);

        $description = '"' . ucwords($this->permission['description']) . '" permission has been revoked.';
        $this->auditLog($revoke, $id, 'UMS', $description);
    }

    public function clear()
    {
        $this->reset(['status', 'email', 'name']);
    }

    public function render()
    {
        $this->search();
        return view('ums::livewire.permission-detail');
    }

}