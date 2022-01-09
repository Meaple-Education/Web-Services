<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function (Request $request) {
    return response()->json([
        'msg' => 'I am teacher',
    ]);
})->name('default');

Route::post('/', function (Request $request) {
    return response()->json([
        'msg' => 'I am teacher POST',
    ]);
})->name('default');

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('register', 'V1\\Teacher\\UserController@register')->name('register');
    Route::post('login', 'V1\\Teacher\\UserController@login')->name('login');
    Route::post('verify/account', 'V1\\Teacher\\UserController@verifyAccount')->name('verifyAccount');
});

Route::group(['middleware' => ['auth:api', 'v1.teacher.token']], function () {
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('profile', 'V1\\Teacher\\UserController@getProfile')->name('profile');
        // Route::post('logout', 'V1\\Teacher\\UserController@getProfile')->name('profile');
        Route::post('verify/password', 'V1\\Teacher\\UserController@passwordVerify')->name('verifyPassword');
    });
    Route::group(['prefix' => 'school', 'as' => 'school.'], function () {
        Route::get('/', 'V1\\Teacher\\SchoolController@getSchools')->name('list');
        Route::post('/', 'V1\\Teacher\\SchoolController@createSchool')->name('add');

        Route::group(['prefix' => '{schoolID}', 'middleware' => ['v1.teacher.school.validate']], function () {
            Route::get('/', 'V1\\Teacher\\SchoolController@getSchool')->name('info');
            Route::post('/', 'V1\\Teacher\\SchoolController@updateSchool')->name('update');
            Route::post('/status', 'V1\\Teacher\\SchoolController@updateSchoolStatus')->name('update.status');
            Route::delete('/', 'V1\\Teacher\\SchoolController@deleteSchool')->name('delete');
        });
    });
});
