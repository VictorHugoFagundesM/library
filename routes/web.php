<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UserController;
use App\Models\BookLoan;
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

Route::get    ('/books',             [BookController::class, 'index']);
Route::get    ('/books/create',      [BookController::class, 'createEdit']);
Route::get    ('/books/{id}/edit',   [BookController::class, 'createEdit']);
Route::post   ('/books',             [BookController::class, 'insertUpdate']);
Route::put    ('/books',             [BookController::class, 'insertUpdate']);
Route::delete ('/books',             [BookController::class, 'delete']);

Route::get    ('/genres',             [GenreController::class, 'index']);
Route::get    ('/genres/create',      [GenreController::class, 'createEdit']);
Route::get    ('/genres/{id}/edit',   [GenreController::class, 'createEdit']);
Route::post   ('/genres',             [GenreController::class, 'insertUpdate']);
Route::put    ('/genres',             [GenreController::class, 'insertUpdate']);
Route::delete ('/genres',             [GenreController::class, 'delete']);

Route::get  ('/loans',                [BookLoanController::class, 'index']);
Route::get  ('/loans/create',         [BookLoanController::class, 'createEdit']);
Route::get  ('/loans/{id}/edit',      [BookLoanController::class, 'createEdit']);
Route::post ('/loans',                [BookLoanController::class, 'insertUpdate']);
Route::put  ('/loans',                [BookLoanController::class, 'insertUpdate']);
Route::post ('/loans/{id}/return',    [BookLoanController::class, 'returnBook']);
Route::post ('/loans/{id}/mark-past', [BookLoanController::class, 'markPastDue']);
