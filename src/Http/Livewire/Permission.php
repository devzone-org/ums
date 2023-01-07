<?php


namespace Devzone\UserManagement\Http\Livewire;


use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;


class Permission extends Component
{
    use WithPagination;

    public $success;
    public $user_id;
    public $user;
    public $portals = [];
    public $portal;
    public $keyword;


    public function mount($id)
    {
        $this->user_id = $id;
        $this->user = User::find($id);
        $this->portals = \Spatie\Permission\Models\Permission::where('portal', '!=', 'teacher_management')->groupBy('portal')->select('portal')->get()->toArray();
    }

    public function render()
    {
        $permissions = \Spatie\Permission\Models\Permission::when(!empty($this->portal), function ($q) {
            return $q->where('portal', $this->portal);
        })->when(!empty($this->keyword), function ($q) {
            return $q->where('name', 'LIKE', '%' . $this->keyword . '%')->orWhere('section', 'LIKE', '%' . $this->keyword . '%');
        })->orderBy('portal')->orderBy('section')->paginate(30);

        return view('ums::livewire.permissions', compact('permissions'));
    }

//    public function updatedKeyword($value)
//    {
//
//        $this->permissions = \Spatie\Permission\Models\Permission::when(!empty($value), function ($q) use ($value) {
//
//            return $q->orWhere('name', 'LIKE', '%' . $value . '%')->orWhere('section', 'LIKE', '%' . $value . '%')->orWhere('portal', 'LIKE', '%' . $value . '%');
//
//        })->get()->toArray();
//
//    }

//    public function assign($name)
//    {
//        $this->user->givePermissionTo($name);
//    }
//
//
//    public function revoke($name)
//    {
//        $this->user->revokePermissionTo($name);
//    }

}
