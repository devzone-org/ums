<?php

namespace Devzone\UserManagement\Http\Livewire;

use App\Models\User;
use Devzone\UserManagement\Traits\LogActivityManualTrait;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Permission extends Component
{
    use LogActivityManualTrait;

    public $user_id, $user, $success;
    public $portal, $assigned_keyword, $unassigned_keyword;
    public $portals = [];
    public $assigned_permissions = [];
    public $unassigned_permissions = [];
    public $adding_permissions_ids = [];
    public $removing_permissions_ids = [];
    public $assign_selected_permissions = [];
    public $revoke_selected_permissions = [];


    public function mount($id)
    {
        $this->user_id = $id;
        $this->user = User::find($id);
        $this->portals = \Spatie\Permission\Models\Permission::where('portal', '!=', 'teacher_management')
            ->groupBy('portal')
            ->select('portal')
            ->get()
            ->toArray();

        $this->getAssignedPermissions();
        $this->getUnassignedPermissions();

    }

    public function updatedAssignedKeyword()
    {
        $this->getAssignedPermissions();
    }

    public function updatedUnassignedKeyword()
    {
        $this->getUnassignedPermissions();
    }

    public function getAssignedPermissions()
    {
        try {
            $this->assigned_permissions = \Spatie\Permission\Models\Permission::where('portal', '!=', 'teacher_management')
                ->when(!empty($this->portal), function ($q) {
                    return $q->where('portal', $this->portal);
                })
                ->when(!empty($this->assigned_keyword), function ($q) {
                    return $q->whereIn('name', $this->user->getPermissionNames()->toArray())
                        ->where('description', 'LIKE', '%' . $this->assigned_keyword . '%')
                        ->orWhere('section', 'LIKE', '%' . $this->assigned_keyword . '%');
                })
                ->whereIn('name', $this->user->getPermissionNames()->toArray())
                ->orderBy('portal')
                ->orderBy('section')
                ->get()
                ->toArray();

            $this->assigned_permissions = array_values($this->assigned_permissions);

        } catch (\Exception $ex) {
            $this->addError('error', $ex->getMessage());
        }
    }

    public function getUnassignedPermissions()
    {
        try {
            $this->unassigned_permissions = \Spatie\Permission\Models\Permission::where('portal', '!=', 'teacher_management')
                ->when(!empty($this->portal), function ($q) {
                    return $q->where('portal', $this->portal);
                })
                ->when(!empty($this->unassigned_keyword), function ($q) {
                    return $q->whereNotIn('name', $this->user->getPermissionNames()->toArray())
                        ->where('description', 'LIKE', '%' . $this->unassigned_keyword . '%')
                        ->orWhere('section', 'LIKE', '%' . $this->unassigned_keyword . '%');
                })
                ->whereNotIn('name', $this->user->getPermissionNames()->toArray())
                ->orderBy('portal')
                ->orderBy('section')
                ->get()
                ->toArray();

            $this->unassigned_permissions = array_values($this->unassigned_permissions);

        } catch (\Exception $ex) {
            $this->addError('error', $ex->getMessage());
        }
    }

    public function selectOnly()
    {
        foreach ($this->adding_permissions_ids as $uap) {
            $uap_index = array_search($uap, array_column($this->unassigned_permissions, 'name'));
            $this->assigned_permissions[] = $this->unassigned_permissions[$uap_index];
            unset($this->unassigned_permissions[$uap_index]);
            $this->unassigned_permissions = array_values($this->unassigned_permissions);
            $this->assign_selected_permissions[] = $uap;
        }

        $this->adding_permissions_ids = [];
    }

    public function unselectOnly()
    {
        foreach ($this->removing_permissions_ids as $ap) {
            $ap_index = array_search($ap, array_column($this->assigned_permissions, 'name'));
            $this->unassigned_permissions[] = $this->assigned_permissions[$ap_index];
            unset($this->assigned_permissions[$ap_index]);
            $this->assigned_permissions = array_values($this->assigned_permissions);
            $this->revoke_selected_permissions[] = $ap;
        }

        $this->removing_permissions_ids = [];
    }

    public function savePermissionsData()
    {
        $assign_description = '';
        $revoke_description = '';

        if (!empty($this->assign_selected_permissions)) {
            foreach ($this->assign_selected_permissions as $new_add) {

                $this->user->givePermissionTo("$new_add");

                $assign_description = $assign_description . '"'
                    . ucwords(\Spatie\Permission\Models\Permission::where('name', $new_add)
                        ->select('description')->first()['description'])
                    . '", ';
            }
            if (count($this->assign_selected_permissions) == 1) {
                $assign_description = $assign_description . 'permission has been assigned.';
            } else {
                $assign_description = $assign_description . 'permissions have been assigned.';
            }

            $this->assign_selected_permissions = [];
        }

        if (!empty($this->revoke_selected_permissions)) {
            foreach ($this->revoke_selected_permissions as $new_remove) {

                $this->user->revokePermissionTo("$new_remove");

                $revoke_description = $revoke_description . '"'
                    . ucwords(\Spatie\Permission\Models\Permission::where('name', $new_remove)
                        ->select('description')->first()['description'])
                    . '", ';
            }
            if (count($this->revoke_selected_permissions) == 1) {
                $revoke_description = $revoke_description . 'permission has been revoked.';
            } else {
                $revoke_description = $revoke_description . 'permissions have been revoked.';
            }

            $this->revoke_selected_permissions = [];
        }

        $this->success = $assign_description . $revoke_description;

        $description = $this->success;
        $this->auditLog($this->user, $this->user_id, 'UMS', $description);

        $this->reset(['assigned_keyword', 'unassigned_keyword']);
        $this->getAssignedPermissions();
        $this->getUnassignedPermissions();

    }

    public function updateData()
    {
        $this->adding_permissions_ids = [];
        $this->removing_permissions_ids = [];
        $this->reset(['assigned_keyword', 'unassigned_keyword']);
        $this->getAssignedPermissions();
        $this->getUnassignedPermissions();
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
        return view('ums::livewire.permissions');
    }


}
