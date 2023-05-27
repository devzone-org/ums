<?php

namespace Devzone\UserManagement\Http\Livewire;

use App\Models\User;
use Livewire\Component;


class UserActivity extends Component
{
    public $status = 't';
    public $email;
    public $name;
    public $users;

    public function search()
    {
        $this->users = User::where(function ($q) {
            return $q->whereNull('type')->orwhereIn('type', ['admin', '']);
        })
            ->when(!empty($this->status), function ($q) {
            return $q->where('status', $this->status);
        })
            ->when(!empty($this->email), function ($q) {
            return $q->where('email', $this->email);
        })
            ->when(!empty($this->name), function ($q) {
            return $q->where('name', 'LIKE', '%' . $this->name . '%');
        })
            ->get()->toArray();
    }

    public function clear(){

        $this->reset(['status','email','name']);
    }

    public function render()
    {
        $this->search();
        return view('ums::livewire.user-activity');
    }

}
