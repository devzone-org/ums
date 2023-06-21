<?php

namespace Devzone\UserManagement\Http\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Schema;

class ActivityDetails extends Component
{
    public $user_activity = [];
    public $target_id;

    public function mount($id)
    {
        $this->target_id = $id;

        if (Schema::hasTable('activity_log') && Schema::hasColumn('activity_log', 'target_id')) {
            $this->user_activity = Activity::where('log_name', 'UMS')
                ->where('target_id', $this->target_id)
                ->select('id', 'description', 'causer_id', 'created_at')
                ->orderBy('id', 'desc')
                ->get()
                ->toArray();
        }
    }

    public function render()
    {
        return view('ums::livewire.activity-details');
    }

}
