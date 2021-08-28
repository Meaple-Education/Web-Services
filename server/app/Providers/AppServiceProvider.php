<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('App\Http\Controllers\V1\Teacher\UserController', function () {
            return new \App\Http\Controllers\V1\Teacher\UserController(new \App\Tution\Teacher\ServicesImpl\UserServiceImpl(new \App\Tution\RepositoriesImpl\UserRepositoryImpl));
        });
    }
}
