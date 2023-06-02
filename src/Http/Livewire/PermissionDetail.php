<?php

namespace Devzone\UserManagement\Http\Livewire;

use App\Models\Permission;
use App\Models\User;
use Devzone\UserManagement\Traits\LogActivityManualTrait;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

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

        $description = 'A permission has been assigned.';
        $this->auditLog($assign, $id, 'UMS', $description);
    }


    public function revoke($id)
    {
        $revoke = User::find($id);
        $revoke->revokePermissionTo($this->permission['name']);

        $description = 'A permission has been revoked.';
        $this->auditLog($revoke, $id, 'UMS', $description);
    }

    public function clear()
    {
        $this->reset(['status', 'email', 'name']);
    }

    public function auditLog($performed_on, $target_id, $log_name, $description)
    {
        if (!empty($description)) {
            activity()
                ->causedBy(\auth()->id())
                ->performedOn($performed_on)
                ->tap(function (Activity $activity) use ($target_id, $log_name) {
                    $activity->target_id = $target_id ?? null;
                    $activity->log_name = $log_name;
                })
                ->log($description);
        }
    }

    public function render()
    {
        $this->search();
        return view('ums::livewire.permission-detail');
    }

}