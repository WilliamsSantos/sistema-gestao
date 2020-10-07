<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/{name}/registrar','RegisterController@index' )->name('registrar');
Route::get('/{name}/validar', 'RegisterController@showRegistries')->middleware(['check.admin'])->name('validar');

Route::prefix('api')->group(function () {
    Route::post('/register', 'RegisterController@createUser')->name('create');
    Route::get('/users', 'RegisterController@listAllRegistries')->name('get-users');
    Route::put('/validate/user/{id}', 'ValidateController@validateUser')->name('validate-user');
});
