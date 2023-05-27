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
        if (Auth::user()->type == 'student') {
            return redirect()->to('student/dashboard');
        }
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

    Route::group(['middleware' => ['can:1.user-permission']], function () {

        Route::get('permissions-list', function () {
            return view('ums::permissions-list');
        });

        Route::get('permission-detail/{id}', function ($id) {
            return view('ums::permission-detail', compact('id'));
        });
    });

    Route::group(['middleware' => ['can:1.user-activity']], function () {

        Route::get('user-activity', function () {
            return view('ums::user-activity');
        });

        Route::get('activity-details/{id}', function ($id) {
            return view('ums::activity-details', compact('id'));
        });
    });

});

Route::get('login', function () {
    if (env('UMS_LOGIN') == 'true') {
        return view('ums::login');
    } else {
        return redirect()->back();
    }
});

Route::post('ums/auth', [\Devzone\UserManagement\Http\Controllers\AuthController::class, 'store']);

Route::get('ums/logout', [\Devzone\UserManagement\Http\Controllers\LogoutController::class, 'destroy']);


Route::get('super-admin', function () {
    $user = User::find(1);
    foreach (Permission::get() as $p) {
        $user->givePermissionTo($p->name);
    }
});
