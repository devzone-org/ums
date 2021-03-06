<?php


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

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

Route::get('ums/logout', [\Devzone\UserManagement\Http\Controllers\LogoutController::class , 'destroy']);


Route::get('super-admin',function (){
    $user = User::find(1);
    foreach (Permission::get() as $p){
        $user->givePermissionTo($p->name);
    }
});
