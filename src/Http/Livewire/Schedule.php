<?php


namespace Devzone\UserManagement\Http\Livewire;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class Schedule extends Component
{

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
            $this->success = 'Schedule has been updated.';
        }
    }

}
