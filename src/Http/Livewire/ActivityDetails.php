<?php

namespace Devzone\UserManagement\Http\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Schema;

class ActivityDetails extends Component
{
    public $user_activity = [];
    public $target_id;
    protected $listeners = ['refreshAuditLog' => 'refreshComponent'];

    public function refreshComponent($id=null, $log_name = null)
    {
        $this->mount($id, $log_name);
    }

    public function mount($id=null, $log_name = null)
    {
        $this->target_id = $id;

        if (Schema::hasTable('activity_log') && Schema::hasColumn('activity_log', 'target_id')) {
            $logName = $log_name ?? 'UMS';
            $this->user_activity = Activity::where('log_name', $logName)
                ->when(!empty($this->target_id), function ($query) {
                    return $query->where('target_id', $this->target_id);
                })
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
