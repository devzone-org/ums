<?php


namespace Devzone\UserManagement\Http\Livewire;


use App\Models\User;
use Devzone\UserManagement\Models\IpRestriction;
use Livewire\Component;

class IPWhitelist extends Component
{


    public $user;
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
        if (IpRestriction::where('ip', $this->ip)->where('user_id', $this->user->id)->exists()) {
            $this->addError('ip', 'This ip already added.');
        } else {
            IpRestriction::create([
                'ip' => $this->ip,
                'status' => $this->status
            ]);
        }

        $this->reset(['type', 'ip', 'status']);


    }

    public function edit($id)
    {
        $this->type = 'edit';
        $this->primary_id = $id;
        $ip = IpRestriction::find($id);
        $this->ip = $ip->ip;
        $this->status = $ip->status;
    }

    public function editIp()
    {
        IpRestriction::find($this->primary_id)->update([
            'ip' => $this->ip,
            'status' => $this->status
        ]);

        $this->reset('type');
    }


}
