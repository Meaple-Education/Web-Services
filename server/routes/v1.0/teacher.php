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
        Route::post('verify/password', 'V1\\Teacher\\UserController@passwordVerify')->name('verifyPassword');
    });
});
