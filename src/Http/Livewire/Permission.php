<?php

namespace Devzone\UserManagement\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Permission extends Component
{
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
        if (!empty($this->assign_selected_permissions)) {
            foreach ($this->assign_selected_permissions as $new_add) {
                $this->user->givePermissionTo("$new_add");
            }
            if (count($this->assign_selected_permissions) == 1) {
                $this->success = 'The permission has been changed.';
            } else {
                $this->success = 'The permissions have been changed.';
            }
            $this->assign_selected_permissions = [];
        }

        if (!empty($this->revoke_selected_permissions)) {
            foreach ($this->revoke_selected_permissions as $new_remove) {
                $this->user->revokePermissionTo("$new_remove");
            }
            if (count($this->revoke_selected_permissions) == 1) {
                $this->success = 'The permission has been changed.';
            } else {
                $this->success = 'The permissions have been changed.';
            }
            $this->revoke_selected_permissions = [];
        }

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

    public function render()
    {
        return view('ums::livewire.permissions');
    }


}
