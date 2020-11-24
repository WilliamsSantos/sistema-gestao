<?php

use Illuminate\Support\Facades\Route;

Route::get('/{name}/registrar','RegisterController@render' )->name('register');
Route::get('/{name}/validar', 'RegisterController@render')->middleware(['check.admin'])->name('valid');
