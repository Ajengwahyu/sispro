<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin10Controller;
use App\Http\Controllers\User10Controller;

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

Route::get('/', function () {
    return redirect('/login10');
});

Route::group(['Middleware' => ['isNotLogged']], function () {
    // Login & Register
    Route::view('/register10', 'register');
    Route::view('/login10', 'login');
    Route::post('/register10', [User10Controller::class, 'Register10']);
    Route::post('/login10', [User10Controller::class, 'Login10']);
});