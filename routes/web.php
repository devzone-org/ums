<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('ums::profile');
    });


    Route::get('change-password', function () {
        return view('ums::change-password');
    });

    Route::group(['middleware' => ['can:1.user.list']], function () {
        Route::get('users', function () {
            return view('ums::users');
        });
    });

    Route::group(['middleware' => ['can:1.user.create']], function () {
        Route::get('users/add', function () {
            return view('ums::add-user');
        });
    });


    Route::get('users/edit/{id}', function ($id) {
        return view('ums::edit-user', compact('id'));
    });
});

Route::get('login', function () {
    return view('ums::login');
});
