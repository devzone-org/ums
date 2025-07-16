<?php

namespace Devzone\UserManagement\Http\Livewire;
use App\Models\User;
use Devzone\UserManagement\Traits\LogActivityManualTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class ManageRoles extends Component
{

    use LogActivityManualTrait;
    public $is_edit = false;
    public $open_modal = false;
    public $edit_id;
    public $delete_id;
    public $role_name= '';
    public $success;
    public $roles;

    protected $rules = [
        'role_name' => 'required',
    ];

    public function mount()
    {
        $this->fetchRoles();
    }

    public function fetchRoles()
    {
        $this->roles = Role::withCount('permissions')->get()->toArray();
    }

    public function editRole($id)
    {
        try {
            if (!empty($id)) {
                $role_found = Role::find($id);
                if (!empty($role_found)) {
                    $this->edit_id = $id;
                    $this->role_name = $role_found->name;
                    $this->is_edit = true;
                }else{
                    throw new \Exception('Role not found!');
                }
            }
        }catch (\Exception $e){
            $this->addError('error',$e->getMessage());
        }
    }
    public function confirmDelete($id){
        $this->delete_id = $id;
        $this->open_modal = true;
    }
    public function deleteRole()
    {
        try {
            if (!auth()->user()->can('1.manage-role')) {
                $this->open_modal = false;
                throw new \Exception("You don't have the permission to perform this action.");
            }

            $role = Role::find($this->delete_id);

            if (!$role) {
                $this->open_modal = false;
                throw new \Exception('Role not found!');
            }
            if (auth()->user()->hasRole($role->name)) {
                $this->open_modal = false;
                throw new \Exception("You can't delete a role assigned to yourself.");
            }

            $roleName = $role->name;
            $role->delete();

            $this->success = 'Role has been deleted!!!';
            $this->auditLog($role, $role->id, 'ManageRole', 'Role ' . $roleName . ' has been deleted.');
            $this->emit('refreshAuditLog', null, "ManageRole");
            $this->fetchRoles();
            $this->open_modal = false;
            $this->reset('is_edit', 'role_name', 'delete_id');

        } catch (\Exception $e) {
            $this->addError('error', $e->getMessage());
        }
    }



    public function addRole()
    {
        $this->success = '';

        $this->validate();
        try {
            if (!$this->is_edit) {
                if (!auth()->user()->can('1.manage-role')) {
                    throw new \Exception("You don't have the permission to perform this action.");
                }

                $is_duplicate = Role::where('name', $this->role_name)->first();
                if(!empty($is_duplicate)){
                    throw new \Exception('Role already exists!');
                }
                $role = Role::create(['name' => $this->role_name]);

                $this->success = 'New Role has been added!!!';
                $this->auditLog($role, $role->id, 'ManageRole', 'Role ' . $this->role_name . ' has been added.');
                $this->emit('refreshAuditLog',null,"ManageRole");

                $this->reset('role_name');
                $this->fetchRoles();
            } else {
                if (!auth()->user()->can('1.manage-role')) {
                    throw new \Exception("You don't have the permission to perform this action.");
                }
                $is_duplicate = Role::where('name', $this->role_name)
                    ->where('id', '!=', $this->edit_id)
                    ->first();
                if(!empty($is_duplicate)){
                    throw new \Exception('Role already exists!');
                }
                $found = Role::find($this->edit_id);

                if (!$found) {
                    throw new \Exception('Role not found!');
                }

                $old_data = $found->toArray();
                $new_data = [
                    'name' => $this->role_name,
                ];
                $found->update($new_data);

                $description = '';
                if ($old_data['name'] !== $this->role_name) {
                    $this->success = 'Role edited!!!';
                    $description = "Changed role name from '{$old_data['name']}' to '{$this->role_name}'";
                }

                $this->auditLog($found, $found->id, 'ManageRole', $description);
                $this->emit('refreshAuditLog',null,"ManageRole");
                $this->reset(['is_edit','role_name']);
                $this->fetchRoles();

            }
        } catch (\Exception $e) {
            $this->addError('error',$e->getMessage());
        }
    }

    public function render()
    {
        return view('ums::livewire.manage-roles');
    }
}