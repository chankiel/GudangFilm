<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\JwtMiddleware;

Route::middleware([JwtMiddleware::class,AdminMiddleware::class])->group(function(){
    Route::get('films',[FilmController::class,'index']);
    Route::get('films/{id}',[FilmController::class,'show']);

    Route::post('films',[FilmController::class,'store']);

    Route::put('films/{id}',[FilmController::class,'update']);

    Route::delete('films/{id}',[FilmController::class,'destroy']);

    Route::post('users/{id}/balance',[UserController::class,'addBalance']);

    Route::get('self',[UserController::class,'self'])
    ->withoutMiddleware([AdminMiddleware::class]);

    Route::delete('users/{id}',[UserController::class,'destroy']);
});

Route::post('register',[UserController::class,'store']);
Route::post('login',[AuthController::class,'login']);