<?php
namespace Devzone\UserManagement\Http\Livewire;
use App\Models\Permission;
use Livewire\Component;

class PermissionsList extends Component
{
    public $success;
    public $permissions = [];
    public $keyword;


    public function mount()
    {
        $this->permissions = \Spatie\Permission\Models\Permission::where('portal','!=', 'teacher_management')->orderBy('portal', 'asc')->get()->toArray();

    }

    public function updatedKeyword($value)
    {

        $this->permissions = \Spatie\Permission\Models\Permission::when(!empty($value),function($q) use ($value) {

            return $q->orWhere('name','LIKE','%'.$value.'%')->orWhere('section','LIKE','%'.$value.'%')->orWhere('portal','LIKE','%'.$value.'%');

        })->orderBy('portal', 'asc')->get()->toArray();

    }

    public function render()
    {
        return view('ums::livewire.permissions-list');
    }

}