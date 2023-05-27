<?php


namespace Devzone\UserManagement\Http\Livewire;


use Devzone\UserManagement\Traits\LogActivityManualTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Schedule extends Component
{
    use LogActivityManualTrait;

    public $success;
    public $user_id;
    public $schedule = [];
    public $days = [];
    public $multi_days;
    public $multi_from;
    public $multi_to;
    public $multi_status;


    public function mount($id)
    {
        $this->user_id = $id;
        $this->days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    }

    public function render()
    {
        $this->search();

        return view('ums::livewire.schedule');
    }

    public function search()
    {
        $record = \Devzone\UserManagement\Models\Schedule::where('user_id', $this->user_id)->get();

        $this->reset('schedule');

        foreach ($this->days as $d) {
            $re = $record->where('day', $d)->first();
            if (empty($re)) {
                $this->schedule[] = ['day' => $d];
            } else {
                $this->schedule[] = $re;
            }
        }
    }

    public function updateSchedule()
    {
        foreach ($this->schedule as $s)
            \Devzone\UserManagement\Models\Schedule::updateOrCreate([
                'day' => $s['day'],
                'user_id' => $this->user_id
            ], [
                    'from' => $s['from'] ?? null,
                    'to' => $s['to'] ?? null,
                    'status' => $s['status'] ?? null,
                ]
            );

        $description = 'Schedule has been updated.';
        $this->auditLog(\Devzone\UserManagement\Models\Schedule::find($this->user_id), $this->user_id, 'UMS', $description);

        $this->success = 'Schedule has been updated.';
    }

    public function multipleUpdateSchedule()
    {
        if (!empty($this->multi_days)) {
            foreach ($this->multi_days as $day) {
                \Devzone\UserManagement\Models\Schedule::updateOrCreate([
                    'user_id' => $this->user_id,
                    'day' => $day,
                ], [
                    'from' => $this->multi_from,
                    'to' => $this->multi_to,
                    'status' => $this->multi_status,
                ]);
            }

            $description = 'Schedule has been updated.';
            $this->auditLog(\Devzone\UserManagement\Models\Schedule::find($this->user_id), $this->user_id, 'UMS', $description);

            $this->success = 'Schedule has been updated.';
        }
    }

    public function auditLog($performed_on, $target_id, $log_name, $description)
    {
        if (!empty($description)) {
            activity()
                ->causedBy(\auth()->id())
                ->performedOn($performed_on)
                ->tap(function (Activity $activity) use ($target_id, $log_name) {
                    $activity->target_id = $target_id ?? null;
                    $activity->log_name = $log_name;
                })
                ->log($description);
        }
    }

}
