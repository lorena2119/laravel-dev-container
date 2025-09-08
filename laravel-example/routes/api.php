<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('health', fn() => ['ok' =>true])->middleware('auth:api', 'scopes:posts.read');

Route::prefix('posts')->group(function (){
    Route::middleware(['throttle:api', 'auth:api', 'scopes:posts.read', 'role:viewer,editor,admin'])->group(function (){
        Route::get('/', [PostController::class, 'index']);
        Route::get('{id}', [PostController::class, 'show']);
    });

    //escritor o admin
    Route::middleware(['throttle:api', 'auth:api', 'role:editor,admin'])->group(function (){
        Route::post('/', [PostController::class, 'store']);
        Route::put('{post}', [PostController::class, 'update']);
        Route::delete('{post}', [PostController::class, 'destroy']);
        Route::post('{post}/restore', [PostController::class, 'restore'])
            ->middleware('scopes:posts.write');
    });
});

Route::prefix('auth')->group(function (){
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);

    Route::middleware(['auth:api'])->group(function (){
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
