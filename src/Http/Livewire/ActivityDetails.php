<?php

namespace Devzone\UserManagement\Http\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ActivityDetails extends Component
{
    public $user_activity;
    public $target_id;

    public function mount($id)
    {
        $this->target_id = $id;
        $this->user_activity = Activity::where('log_name', 'UMS')
            ->where('target_id', $this->target_id)
            ->select('id','description', 'causer_id', 'created_at')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    }
    public function render()
    {
        return view('ums::livewire.activity-details');
    }

}
