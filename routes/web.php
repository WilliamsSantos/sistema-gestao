<?php

use Illuminate\Support\Facades\Route;

Route::get('/{name}/registrar','RegisterController@index' )->name('register');
Route::get('/{name}/validar', 'RegisterController@index')->middleware(['check.admin'])->name('valid');

Route::prefix('api')->group(function () {
    Route::post('/register', 'RegisterController@createUser')->name('create');
    Route::get('/users', 'RegisterController@listAllRegistries')->name('get-users');
    Route::put('/validate/user/{id}', 'ValidateController@validateUser')->name('validate-user');
});
