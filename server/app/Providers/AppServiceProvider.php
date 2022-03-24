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
        // Admin
        // Teacher
        $this->app->bind('App\Http\Controllers\V1\Teacher\UserController', function () {
            return new \App\Http\Controllers\V1\Teacher\UserController(
                new \App\Tution\Teacher\ServicesImpl\UserServiceImpl(
                    new \App\Tution\RepositoriesImpl\UserRepositoryImpl
                )
            );
        });

        $this->app->bind('App\Http\Controllers\V1\Teacher\SchoolController', function () {
            return new \App\Http\Controllers\V1\Teacher\SchoolController(
                new \App\Tution\Teacher\ServicesImpl\SchoolServiceImpl(
                    new \App\Tution\RepositoriesImpl\SchoolRepositoryImpl
                )
            );
        });

        $this->app->bind('App\Http\Controllers\V1\Teacher\SchoolClassController', function () {
            return new \App\Http\Controllers\V1\Teacher\SchoolClassController(
                new \App\Tution\Teacher\ServicesImpl\SchoolClassServiceImpl(
                    new \App\Tution\RepositoriesImpl\SchoolClassRepositoryImpl
                )
            );
        });

        //Student
        $this->app->bind('App\Http\Controllers\V1\Student\UserController', function () {
            return new \App\Http\Controllers\V1\Student\UserController(
                new \App\Tution\Student\ServicesImpl\UserServiceImpl(
                    new \App\Tution\RepositoriesImpl\StudentRepositoryImpl
                )
            );
        });
    }
}
