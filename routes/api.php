<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// module posts
Route::get('/posts', [PostController::class,'index']);
Route::post('/post', [PostController::class,'store']);
Route::get('/post/{slug}', [PostController::class, 'show']);
Route::get('/post/{slug}/edit', [PostController::class, 'edit']);
Route::post('/post/{id}/edit', [PostController::class, 'update']);
Route::delete('/posts/{id}/delete', [PostController::class, 'destroy']);


// module categories
Route::get('/categories', [CategoryController::class,'index']);
Route::post('/category', [CategoryController::class,'store']);
Route::get('/category/{slug}', [CategoryController::class, 'show']);
Route::get('/category/{slug}/edit', [CategoryController::class, 'edit']);
Route::put('/category/{id}/edit', [CategoryController::class, 'update']);
Route::delete('/category/{id}/delete', [CategoryController::class, 'destroy']);

// module users
Route::get('/users', [UserController::class,'index']);
Route::post('/user', [UserController::class,'store']);