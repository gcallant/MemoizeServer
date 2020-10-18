<?php

use App\Http\Controllers\HomeController;
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
Route::get('/user', function(Request $request) {
    return \App\User::find(1);
})->middleware('auth:api');
Route::post('/user', 'UserController@store')->middleware('client:create-users');
Route::post('/login', 'Auth\LoginController@login');
Route::get('home', [HomeController::class, 'index']);

