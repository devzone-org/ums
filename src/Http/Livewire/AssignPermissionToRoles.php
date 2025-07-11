<?php

namespace Devzone\UserManagement\Http\Livewire;

use Devzone\UserManagement\Traits\LogActivityManualTrait;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignPermissionToRoles extends Component
{
    use LogActivityManualTrait;
    public $role_id, $role, $success;
    public $portal, $assigned_keyword, $unassigned_keyword,$assigned_permissions_count;
    public $portals = [];
    public $assigned_permissions = [];
    public $unassigned_permissions = [];
    public $adding_permissions_ids = [];
    public $removing_permissions_ids = [];
    public $assign_selected_permissions = [];
    public $revoke_selected_permissions = [];

    public function mount($id)
    {
        $this->role_id = $id;
        $this->role = Role::findOrFail($id);

        $this->portals = Permission::where('portal', '!=', 'teacher_management')
            ->groupBy('portal')
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
            $assignedNames = $this->role->permissions->pluck('name')->toArray();
            $assignedPermissionsQuery = Permission::where('portal', '!=', 'teacher_management')
                ->when($this->portal, function ($q) {
                    return $q->where('portal', $this->portal);
                })
                ->when($this->assigned_keyword, function ($q) use ($assignedNames) {
                    return $q->whereIn('name', $assignedNames)
                        ->where(function ($q) {
                            $q->where('description', 'LIKE', '%' . $this->assigned_keyword . '%')
                                ->orWhere('section', 'LIKE', '%' . $this->assigned_keyword . '%');
                        });
                })
                ->whereIn('name', $assignedNames)
                ->orderBy('portal')
                ->orderBy('section');
            $assignedPermissions = $assignedPermissionsQuery->get()->toArray();
            $this->assigned_permissions = $assignedPermissions;
            $this->assigned_permissions_count = count($assignedPermissions);
        } catch (\Exception $ex) {
            $this->addError('error', $ex->getMessage());
        }
    }

    public function getUnassignedPermissions()
    {
        try {
            $assignedNames = $this->role->permissions->pluck('name')->toArray();

            $this->unassigned_permissions = Permission::where('portal', '!=', 'teacher_management')
                ->when($this->portal, function ($q) {
                    return $q->where('portal', $this->portal);
                })
                ->when($this->unassigned_keyword, function ($q) use ($assignedNames) {
                    return $q->whereNotIn('name', $assignedNames)
                        ->where(function ($q) {
                            $q->where('description', 'LIKE', '%' . $this->unassigned_keyword . '%')
                                ->orWhere('section', 'LIKE', '%' . $this->unassigned_keyword . '%');
                        });
                })
                ->whereNotIn('name', $assignedNames)
                ->orderBy('portal')->orderBy('section')
                ->get()
                ->toArray();
        } catch (\Exception $ex) {
            $this->addError('error', $ex->getMessage());
        }
    }

    public function selectOnly()
    {


        $unassigned_map = [];
        foreach ($this->unassigned_permissions as $permission) {
            $unassigned_map[$permission['name']] = $permission;
        }
        foreach ($this->adding_permissions_ids as $permName) {
            if (isset($unassigned_map[$permName])) {
                $this->assigned_permissions[] = $unassigned_map[$permName];
                $this->assign_selected_permissions[] = $permName;
                unset($unassigned_map[$permName]);
            }
        }
        $this->unassigned_permissions = array_values($unassigned_map);
        $this->adding_permissions_ids = [];
    }


    public function unselectOnly()
    {
        $new_assigned = [];

        foreach ($this->assigned_permissions as $key => $perm) {
            if (in_array($perm['name'], $this->removing_permissions_ids)) {
                $this->unassigned_permissions[] = $perm;
                $this->revoke_selected_permissions[] = $perm['name'];
            } else {
                $new_assigned[] = $perm;
            }
        }

        $this->assigned_permissions = $new_assigned;
        $this->removing_permissions_ids = [];
    }

    public function savePermissionsData()
    {
        $assign_description = '';
        $revoke_description = '';

        try {
            if (!auth()->user()->can('1.manage-role')) {
                throw new \Exception("You don't have permission to perform this action");
            }
            if (empty($this->assign_selected_permissions) && empty($this->revoke_selected_permissions)) {
                throw new \Exception("Please select permission(s) to assign or revoke.");
            }else{
                if (!empty($this->assign_selected_permissions)) {
                    foreach ($this->assign_selected_permissions as $permName) {
                        $this->role->givePermissionTo($permName);
                        $desc = Permission::where('name', $permName)->value('description');
                        $assign_description .= "\"" . ucwords($desc) . "\", ";
                    }
                    $assign_description .= count($this->assign_selected_permissions) === 1
                        ? 'permission has been assigned.'
                        : 'permissions have been assigned.';
                }
                if (!empty($this->revoke_selected_permissions)) {
                    foreach ($this->revoke_selected_permissions as $permName) {
                        $this->role->revokePermissionTo($permName);
                        $desc = Permission::where('name', $permName)->value('description');
                        $revoke_description .= "\"" . ucwords($desc) . "\", ";
                    }
                    $revoke_description .= count($this->revoke_selected_permissions) === 1
                        ? 'permission has been revoked.'
                        : 'permissions have been revoked.';
                }
                $this->success = $assign_description . ' ' . $revoke_description;
                $this->auditLog($this->role, $this->role_id, 'RolesPermission', $this->success);
                $this->emit('refreshAuditLog', $this->role_id, 'RolesPermission');
                $this->reset(['assign_selected_permissions', 'revoke_selected_permissions', 'assigned_keyword', 'unassigned_keyword']);
                $this->getAssignedPermissions();
                $this->getUnassignedPermissions();
            }

        } catch (\Exception $e) {
            $this->addError('error', $e->getMessage());
        }
    }

    public function updateData()
    {
        $this->reset([
            'adding_permissions_ids',
            'removing_permissions_ids',
            'assign_selected_permissions',
            'revoke_selected_permissions',
            'assigned_keyword',
            'unassigned_keyword'
        ]);
        $this->getAssignedPermissions();
        $this->getUnassignedPermissions();
    }

    public function render()
    {
        return view('ums::livewire.assign-permission-to-roles');
    }
}