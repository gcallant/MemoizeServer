<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

Route::get('isUser', function() {
    return auth()->user();
})->middleware('auth:api');
Route::post('user', [UserController::class, 'store'])->middleware('client:create-users');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('login/confirm', [LoginController::class, 'confirmLogin']);
Route::post('logout', [LoginController::class, 'logout'])->middleware(['auth:api', 'scope:user']);
Route::get('isAuthenticated', function() {
})->middleware('auth:api');

Route::get('randomBytes', [LoginController::class, 'generateRandomID']);
//Route::get('home', [HomeController::class, 'index'])->middleware(['auth:api', 'scope:user']);


Route::get('stats', function() {
    return [
        'series' => 200,
        'lessons' => 1300
    ];
});

Route::get('achievements', function() {
    $user = \request()->user();

    return [
        "phone" => $user->phone,
        "email" => $user->email,
    ];
})->middleware('auth:api');

