<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// The default middleware API guard.
$DEFAULT_MIDDLEWARE = 'auth:api';

/**
 * Route to check if this user is authenticated.
 */
Route::get('isUser', static function() {
    return auth()->user();
})->middleware($DEFAULT_MIDDLEWARE);

/**
 * Route to create a new user.
 */
Route::post('user', [UserController::class, 'store'])->middleware('client:create-users');

/**
 * Route for a user to login.
 */
Route::post('login', [LoginController::class, 'login'])->name('login');

/**
 * The route that is called during the login callback by Laravel Echo.
 */
Route::post('login/confirm', [LoginController::class, 'confirmLogin']);

/**
 * The logout route.
 */
Route::post('logout', [LoginController::class, 'logout'])->middleware([$DEFAULT_MIDDLEWARE, 'scope:user']);

/**
 * The route that is called to check if the user is authenticated before each page load for protected pages.
 * Uses the default middleware API guard.
 */
Route::get('isAuthenticated')->middleware('auth:api');

/**
 * This route gets a stream of pseudo-randomly cryptographically secure bytes.
 */
Route::get('randomBytes', [LoginController::class, 'generateRandomID']);

/**
 * This is an unprotected route that returns static data (for demonstration purposes).
 */
Route::get('stats', static function() {
    return [
        'series'  => 200,
        'lessons' => 1300
    ];
});

/**
 * This is a protected route that fetches a user's achievements along with some basic information.
 */
Route::get('achievements', static function() {
    $user = \request()->user();

    return [
        "phone" => $user->phone,
        "email" => $user->email,
    ];
})->middleware($DEFAULT_MIDDLEWARE);

