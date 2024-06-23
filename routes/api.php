<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Register a new user.
Route::post('/register', 'App\Http\Controllers\AuthController@register');
// Login a user.
Route::post('/login', 'App\Http\Controllers\AuthController@login');

// Group routes that require authentication.
Route::middleware('auth:api')->group(function () {
    // Logout a user.
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
    // Refresh a user's token.
    Route::post('/refresh', 'App\Http\Controllers\AuthController@refresh');
});
