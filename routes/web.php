<?php

use Illuminate\Support\Facades\Route;

/**
 * The "catch-all" route to render our Vue SPA.
 */
Route::get('{any}', static function() {
    return view('layouts.vue');
})->where('any', '.*');

/**
 * The route for verifying a user's email.
 */
Route::get('register/verify/{confirmation_code}', [
    'as'   => 'confirmation_path',
    'uses' => 'Auth\RegisterController@confirm'
]);
