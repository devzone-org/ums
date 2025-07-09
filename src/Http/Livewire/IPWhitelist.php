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
    public $status;
    public $primary_id;

    protected $rules = [
        'ip' => 'required|ip',
        'status' => 'required'
    ];

    public function mount($id)
    {
        $this->user = User::find($id);
    }

    public function render()
    {
        $ips = IpRestriction::get();
        return view('ums::livewire.ip-restriction', compact('ips'));
    }

    public function addIp()
    {
        $this->validate();
        try {
            if (IpRestriction::where('user_id', $this->user->id)->where('ip', $this->ip)->exists()) {
                throw new \Exception('Ip duplication found.');
            }
            if (!empty(env('IP_WHITELIST_LIMIT', 5))) {
                if (intval(IpRestriction::where('user_id', $this->user->id)->where('status', 't')->count()) >= env('IP_WHITELIST_LIMIT', 5)) {
                    throw new \Exception("You have reached the maximum limit of active ip's.");
                }
            } else {
                throw new \Exception("User Ip limit not defined.");
            }
            IpRestriction::create([
                'ip' => $this->ip,
                'user_id' => $this->user->id,
                'status' => $this->status
            ]);
            $this->reset(['type', 'ip', 'status']);
        } catch (\Exception $e) {
            $this->addError('ip', $e->getMessage());

        }


    }

    public function edit($id)
    {
        $this->type = 'edit';
        $this->primary_id = $id;
        $ip = IpRestriction::find($id);
        $this->ip = $ip->ip;
        $this->user_id = $ip->user_id;
        $this->status = $ip->status;
    }

    public function editIp()
    {
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
            if (!$ip) {
                throw new \Exception("IP restriction not found.");
            }
            $ip->update([
                'ip' => $this->ip,
                'status' => $this->status,
            ]);
            $this->reset('type');
        } catch (\Exception $e) {
            $this->addError('ip', $e->getMessage());
        }
    }


}
