<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Storage;

Route::middleware([AdminMiddleware::class])->group(function(){
    Route::apiResource('films',FilmController::class);

    Route::apiResource('users',UserController::class)->except([
        'store','update'
    ]);
    Route::post('users/{id}/balance',[UserController::class,'addBalance']);
});

Route::get('self',[AuthController::class,'self']);
Route::post('login',[AuthController::class,'loginAPI']);