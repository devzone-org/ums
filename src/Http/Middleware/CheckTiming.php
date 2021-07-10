<?php


namespace Devzone\UserManagement\Http\Middleware;

use Closure;
use Devzone\UserManagement\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Spatie\Permission\Models\Permission;

class CheckTiming
{
    public function handle($request, Closure $next)
    {

        $response = $next($request);
        $timing = Redis::get('user.schedule.' . Auth::id());

        if (!empty($timing)) {
            $timing = json_decode($timing, true);
            $day = collect($timing)->where('day', strtolower(date('l')))->first();
            if (!empty($day['status'])) {
                if ($day['status'] == 't') {
                    if ($day['from'] >= date('H:i:s') || $day['to'] <= date('H:i:s')) {
                        abort(403,'You are not allowed to use session at this time.');
                    }
                } else {
                    if ($day['from'] <= date('H:i:s') && $day['to'] >= date('H:i:s')) {
                        abort(403,'You are not allowed to use session at this time.');
                    }
                }
            }
        }

        return $response;
    }
}
