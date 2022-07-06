<?php

namespace Devzone\UserManagement\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;


class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            if ($request->user()->status == 'f') {
                return redirect()->to('ums/ums/logout');
            } else {
                return $response;
            }
        } else {
            return $response;
        }
    }


}