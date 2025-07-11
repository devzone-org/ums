<?php


namespace Devzone\UserManagement\Http\Livewire;


use App\Models\User;
use Devzone\UserManagement\Models\IpRestriction;
use Livewire\Component;

class IPWhitelist extends Component
{


    public $user;
    public $user_id;
    public $type = "listing";
    public $ip;
    public $ips;
    public $status;
    public $primary_id;

    protected $rules = [
        'ip' => 'required|ip',
        'status' => 'required|in:t,f'
    ];

    public function mount($id)
    {
        $this->user = User::find($id);
        if(!empty($this->user)){
            $this->user_id = $id;
            $this->search();
        }
    }

    public function search(){
        $this->ips = IpRestriction::where('user_id', $this->user->id)->get();
    }

    public function render()
    {
        return view('ums::livewire.ip-restriction');
    }

    public function addIp()
    {
        $this->resetErrorBag();
        $this->validate();

        try {
            if (IpRestriction::where('user_id', $this->user->id)->where('ip', $this->ip)->exists()) {
                throw new \Exception('IP duplication found.');
            }
            if ($this->status === 't') {
                $limit = intval(env('IP_WHITELIST_LIMIT', 5));

                if ($limit === 0) {
                    throw new \Exception("User IP limit not defined.");
                }
                $active_ip_count = IpRestriction::where('user_id', $this->user->id)
                    ->where('status', 't')
                    ->count();
                if ($active_ip_count >= $limit) {
                    throw new \Exception("You have reached the maximum limit of active IPs.");
                }
            }
            IpRestriction::create([
                'ip' => $this->ip,
                'user_id' => $this->user->id,
                'status' => $this->status
            ]);

            $this->reset(['type', 'ip', 'status']);
            $this->search();

        } catch (\Exception $e) {
            $this->addError('ip', $e->getMessage());
        }
    }


    public function edit($id)
    {
        $this->type = 'edit';
        $this->primary_id = $id;
        $ip = IpRestriction::find($id);
        if (!$ip) {
            $this->addError('ip', 'IP record not found.');
            return;
        }
        $this->ip = $ip->ip;
        $this->user_id = $ip->user_id;
        $this->status = $ip->status;
    }

    public function editIp()
    {
        $this->resetErrorBag();
        $this->validate();

        try {
            $duplicate = IpRestriction::where('id', '!=', $this->primary_id)
                ->where('user_id', $this->user_id)
                ->where('ip', $this->ip)
                ->exists();

            if ($duplicate) {
                throw new \Exception('IP duplication found.');
            }

            $ip = IpRestriction::find($this->primary_id);
            $is_changing_to_active = $this->status === 't' && $ip->status !== 't';
            if ($is_changing_to_active) {
                $limit = intval(env('IP_WHITELIST_LIMIT', 5));
                if ($limit === 0) {
                    throw new \Exception("User IP limit not defined.");
                }
                $activeCount = IpRestriction::where('user_id', $this->user_id)
                    ->where('status', 't')
                    ->count();
                if ($activeCount >= $limit) {
                    throw new \Exception("You have reached the maximum limit of active IPs.");
                }
            }
            $ip->update([
                'ip' => $this->ip,
                'status' => $this->status,
            ]);
            $this->reset(['type','primary_id','status','ip']);
            $this->search();
        } catch (\Exception $e) {
            $this->addError('ip', $e->getMessage());
        }
    }

    public function setAdd(){
        $this->type = "add";
        $this->reset(['ip', 'status']);
        $this->resetErrorBag();
    }
    public function setListing(){
        $this->type = "listing";
        $this->resetErrorBag();
    }


}
