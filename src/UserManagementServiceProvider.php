<?php

namespace Devzone\UserManagement;

use Devzone\UserManagement\Http\Livewire\AddUser;
use Devzone\UserManagement\Http\Livewire\ChangePassword;
use Devzone\UserManagement\Http\Livewire\EditUser;
use Devzone\UserManagement\Http\Livewire\IPWhitelist;
use Devzone\UserManagement\Http\Livewire\Profile;
use Devzone\UserManagement\Http\Livewire\Schedule;
use Devzone\UserManagement\Http\Livewire\Users;
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
        Livewire::component('profile',Profile::class);
        Livewire::component('change-password',ChangePassword::class);
        Livewire::component('add-user',AddUser::class);
        Livewire::component('edit-user',EditUser::class);
        Livewire::component('users',Users::class);
        Livewire::component('ip-restriction',IPWhitelist::class);
        Livewire::component('schedule',Schedule::class);
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
            __DIR__ . '/../resources/assets' => public_path('ums'),
        ], 'ums.assets');

        // Registering package commands.
        // $this->commands([]);
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
