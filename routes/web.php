<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
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



Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function(){
    return view('welcome');
});

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:api');
Route::get('home', [HomeController::class, 'index'])->middleware('auth:api');

Route::get('register/verify/{confirmation_code}', [
    'as' => 'confirmation_path',
    'uses' => 'Auth\RegisterController@confirm'
]);

Route::get('/startLogin', 'Auth\LoginController@startLogin');
