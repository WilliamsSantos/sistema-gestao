<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::post('/register', 'RegisterController@createUser')->name('create');
    Route::get('/users', 'RegisterController@listAllRegistries')->name('get-users');
    Route::put('/validate/user/{id}', 'ValidateController@validateUser')->name('validate-user');
});
