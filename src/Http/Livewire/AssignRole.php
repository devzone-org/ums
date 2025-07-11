<?php

namespace Devzone\UserManagement\Http\Livewire;

use Devzone\UserManagement\Traits\LogActivityManualTrait;
use Livewire\Component;
use App\Models\ModelHasRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use PhpParser\Node\Expr\AssignOp\Mod;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class AssignRole extends Component
{
    use LogActivityManualTrait;
    public $user;
    public $roles = [];
    public $user_id;
    public $type = "listing";
    public $open_delete_modal = false;
    public $role_id;
    public $delete_id;
    public $user_info;
    public $company_name;
    public $success = '';
    public $assign_role_id;

    protected $rules = [
        'assign_role_id' => 'required'
    ];

    protected $validationAttributes = [
        'assign_role_id' => 'Role'
    ];

    public function mount($user_id)
    {
        $this->roles = Role::all()->keyBy('id')->toArray();
        $this->search($user_id);
        $this->user_id = $user_id;
        $this->user_info = \App\Models\User::find($this->user_id);
    }

    public function search($id)
    {
        $this->assign_role_id = ModelHasRole::join('roles as r','r.id','=','model_has_roles.role_id')
            ->where('model_id', $id)
            ->value('r.id');

    }

    public function save()
    {
        $this->validate();
        $this->reset('success');

        try {
            if (!auth()->user()->can('1.manage-role')) {
                throw new \Exception("You don't have the permission to perform this action.");
            }

            $user = User::findOrFail($this->user_id);

            // Check if the selected role is already assigned — prevent duplicate assignment
            if ($user->hasRole($this->assign_role_id)) {
                throw new \Exception('This role is already assigned to the user.');
            }
            $existingRoles = $user->getRoleNames();
            if ($existingRoles->isNotEmpty()) {
                foreach ($existingRoles as $oldRoleName) {
                    $user->removeRole($oldRoleName);
                    $this->auditLog(
                        $user,
                        $this->user_info->id,
                        'UMS',
                        'Role ' . $oldRoleName . ' unassigned from user ' . $this->user_info->name . '.'
                    );
                }
            }

            $newRole = Role::findOrFail($this->assign_role_id);
            $user->assignRole($newRole->name);

            $this->success = 'Role assigned successfully.';

            $this->auditLog(
                $user,
                $this->user_info->id,
                'UMS',
                'Role ' . $newRole->name . ' assigned to user ' . $this->user_info->name . '.'
            );


            $this->search($this->user_id);

        } catch (\Exception $e) {
            $this->addError('error', $e->getMessage());
        }
    }
    public function render()
    {
        return view('ums::livewire.assign-role');
    }

}