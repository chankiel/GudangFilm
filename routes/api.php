<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\JwtMiddleware;

Route::middleware([JwtMiddleware::class,AdminMiddleware::class])->group(function(){
    Route::apiResource('films',FilmController::class);

    Route::post('users/{id}/balance',[UserController::class,'addBalance']);

    Route::get('self',[UserController::class,'self'])
    ->withoutMiddleware([AdminMiddleware::class]);

    Route::delete('users/{id}',[UserController::class,'destroy']);
});

Route::post('login',[AuthController::class,'login']);