<?php

namespace Devzone\UserManagement\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function store(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);



        $credentials = $request->only('email', 'password');
        $credentials['status'] = 't';
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }else{

            throw ValidationException::withMessages([
                'email' => __('User credentials do not match our records.'),
            ]);
        }


    }
}
