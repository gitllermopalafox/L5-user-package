<?php

namespace SidneyDobber\User;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Load views.
         */
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'user');
        /*
         * Load routes.
         */
        include __DIR__.'/../http/routes.php';
        /*
         * Publish config.
         */
        $this->publishes([
            __DIR__.'/../config/' => config_path('packages/SidneyDobber/User')
        ], 'packages');
        /*
         * Publish migrations.
         */
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('/migrations')
        ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'SidneyDobber\User\UserRepositoryInterface',
            'SidneyDobber\User\EloquentUserRepository'
        );    }
}
