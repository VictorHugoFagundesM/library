<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get    ('/users',             [UserController::class, 'index']);
Route::get    ('/users/create',      [UserController::class, 'createEdit']);
Route::get    ('/users/{id}/edit',   [UserController::class, 'createEdit']);
Route::post   ('/users',             [UserController::class, 'insertUpdate']);
Route::put    ('/users',             [UserController::class, 'insertUpdate']);
Route::delete ('/users',             [UserController::class, 'delete']);

