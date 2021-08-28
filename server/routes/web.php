<?php

use Illuminate\Support\Facades\Route;


Route::any('/', 'InvalidEndpointController@index')->where('all', '.+');
Route::any('{any}/{all?}', 'InvalidEndpointController@index')->where('all', '.+');
