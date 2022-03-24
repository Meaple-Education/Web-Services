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
        'msg' => 'I am student',
    ]);
});

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('register', 'V1\\Student\\UserController@register')->name('register');
    Route::post('login', 'V1\\Student\\UserController@login')->name('login');
    Route::post('verify/account', 'V1\\Student\\UserController@verifyAccount')->name('verifyAccount');
});

Route::group(['middleware' => ['auth:api', 'v1.student.token']], function () {
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('profile', 'V1\\Student\\UserController@getProfile')->name('profile');
        // Route::post('logout', 'V1\\Student\\UserController@getProfile')->name('profile');
        Route::post('verify/password', 'V1\\Student\\UserController@passwordVerify')->name('verifyPassword');
    });
});
