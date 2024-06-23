<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Login error response.
Route::get('/unauthorized', function () {
    return response()->json(['message' => 'Unauthorized'], 401);
})->name('login');
// Register a new user.
Route::post('/register', 'App\Http\Controllers\AuthController@register');
// Login a user.
Route::post('/login', 'App\Http\Controllers\AuthController@login');

// Group routes that require authentication.
Route::middleware(['auth:api'])->group(function () {
    // Logout a user.
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
    // Refresh a user's token.
    Route::post('/refresh', 'App\Http\Controllers\AuthController@refresh');
    // Get all todos for this user.
    Route::get('/todos', 'App\Http\Controllers\Api\TodoController@index');
    // Create a new todo.
    Route::post('/todos', 'App\Http\Controllers\Api\TodoController@store');
    // Get a single todo.
    Route::get('/todos/{id}', 'App\Http\Controllers\Api\TodoController@show');
    // Update a todo.
    Route::put('/todos/{id}', 'App\Http\Controllers\Api\TodoController@update');
    // Delete a todo.
    Route::delete('/todos/{id}', 'App\Http\Controllers\Api\TodoController@destroy');
});
