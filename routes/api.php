<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/posts', [PostController::class,'index']);
Route::post('/post', [PostController::class,'store']);
Route::get('/post/{slug}', [PostController::class, 'show']);
Route::get('/post/{slug}/edit', [PostController::class, 'edit']);
Route::put('/post/{id}/edit', [PostController::class, 'update']);
Route::delete('/posts/{id}/delete', [PostController::class, 'destroy']);