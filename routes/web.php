<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

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

// module posts
Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::get('/post/create', [PostController::class,'create']);
Route::get('/post/{slug}', [PostController::class, 'show']);
Route::get('/post/{slug}/edit', [PostController::class, 'edit']);


// module category
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/category/create', [CategoryController::class,'create']);
Route::get('/category/{slug}', [CategoryController::class, 'show']);
Route::get('/category/{slug}/edit', [CategoryController::class, 'edit']);


// module user
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/user/create', [UserController::class,'create']);