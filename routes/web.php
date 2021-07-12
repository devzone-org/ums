<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('ums::profile');
    });

    Route::get('change-password', function () {
        return view('ums::change-password');
    });


    Route::get('users', function () {
        return view('ums::users');
    });


    Route::get('users/add', function () {
        return view('ums::add-user');
    });


    Route::get('users/edit/{id}', function ($id) {
        return view('ums::edit-user', compact('id'));
    });
});

Route::get('login', function () {
    return view('ums::login');
});
