<?php

namespace Devzone\UserManagement;

use Devzone\UserManagement\Console\DumpMasterData;
use Devzone\UserManagement\Http\Livewire\ActivityDetails;
use Devzone\UserManagement\Http\Livewire\AddUser;
use Devzone\UserManagement\Http\Livewire\AssignPermissionToRoles;
use Devzone\UserManagement\Http\Livewire\AssignRole;
use Devzone\UserManagement\Http\Livewire\Google2fa;
use Devzone\UserManagement\Http\Livewire\ManageRoles;
use Devzone\UserManagement\Http\Livewire\PermissionDetail;
use Devzone\UserManagement\Http\Livewire\PermissionsList;
use Devzone\UserManagement\Http\Livewire\ChangePassword;
use Devzone\UserManagement\Http\Livewire\EditUser;
use Devzone\UserManagement\Http\Livewire\IPWhitelist;
use Devzone\UserManagement\Http\Livewire\Permission;
use Devzone\UserManagement\Http\Livewire\PermissionTr;
use Devzone\UserManagement\Http\Livewire\Profile;
use Devzone\UserManagement\Http\Livewire\Schedule;
use Devzone\UserManagement\Http\Livewire\UserActivity;
use Devzone\UserManagement\Http\Livewire\Users;
use Devzone\UserManagement\Http\Livewire\Verify2fa;
use Devzone\UserManagement\Http\Middleware\CheckStatus;
use Devzone\UserManagement\Http\Middleware\CheckTiming;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class UserManagementServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {

        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(CheckTiming::class);
        $kernel->pushMiddleware(CheckStatus::class);

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'devzone');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ums');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->registerRoutes();


        $this->registerLivewireComponent();
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {

            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    protected function routeConfiguration(): array
    {
        return [
            'prefix' => config('user-management.prefix'),
            'middleware' => config('user-management.middleware'),
        ];
    }

    private function registerLivewireComponent()
    {
        Livewire::component('profile', Profile::class);
        Livewire::component('change-password', ChangePassword::class);
        Livewire::component('google2fa', Google2fa::class);
        Livewire::component('verify2fa', Verify2fa::class);
        Livewire::component('add-user', AddUser::class);
        Livewire::component('edit-user', EditUser::class);
        Livewire::component('users', Users::class);
        Livewire::component('ip-restriction', IPWhitelist::class);
        Livewire::component('schedule', Schedule::class);
        Livewire::component('permission', Permission::class);
        Livewire::component('permissions-list', PermissionsList::class);
        Livewire::component('permission-detail', PermissionDetail::class);
        Livewire::component('permission-tr', PermissionTr::class);
        Livewire::component('user-activity', UserActivity::class);
        Livewire::component('activity-details', ActivityDetails::class);
        Livewire::component('manage-roles', ManageRoles::class);
        Livewire::component('assign-role', AssignRole::class);
        Livewire::component('assign-permission-to-roles', AssignPermissionToRoles::class);
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/user-management.php' => config_path('user-management.php'),
        ], 'ums.config');


        // Publishing the views.
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/ums'),
        ], 'ums.views');

        // Publishing assets.
        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('user'),
        ], 'ums.assets');

        // Registering package commands.
        $this->commands([
            DumpMasterData::class
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/user-management.php', 'user-management');

        // Register the service the package provides.
        $this->app->singleton('user-management', function ($app) {
            return new UserManagement;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['user-management'];
    }
}
