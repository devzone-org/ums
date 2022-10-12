<?php

namespace Devzone\UserManagement\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function store(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);


        $user = User::where('email', $request['email'])->first();

        if (empty($user)){

            throw ValidationException::withMessages([
                'email' => __('User credentials do not match our records.'),
            ]);
        }

        if(Hash::check($request['password'], $user->password)){

            if ($user->status == 'f'){

                throw ValidationException::withMessages([
                    'email' => __('User credentials do not match our records.'),
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended('dashboard');

        }else{

            throw ValidationException::withMessages([
                'email' => __('User credentials do not match our records.'),
            ]);

            return redirect()->to('login');
        }

    }



}