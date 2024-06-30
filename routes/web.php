<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// admin
Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::get('/post/create', [PostController::class,'create']);
Route::get('/post/{slug}', [PostController::class, 'show']);
Route::get('/post/{slug}/edit', [PostController::class, 'edit']);