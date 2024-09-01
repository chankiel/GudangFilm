<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RedirectIfAuth;

Route::get('/', [PageController::class,'home']);

Route::get('/films/{film:slug}',[PageController::class,'filmDetail']);
Route::get('register',[PageController::class,'register'])->middleware([RedirectIfAuth::class]);
Route::get('login',[PageController::class,'login'])->middleware([RedirectIfAuth::class]);

Route::post('/add-user',[UserController::class,'store']);

Route::post('/login-be',[AuthController::class,'login']);
Route::get('/logout-be',[AuthController::class,'logout']);

Route::middleware([AuthMiddleware::class])->group(function(){
    Route::get('/myfilms',[PageController::class,'myfilms'])->middleware([AuthMiddleware::class]);
    Route::get('/wishlist',[PageController::class,'wishlist'])->middleware([AuthMiddleware::class]);

    Route::post('buy-film/{film}',[UserController::class,'buyFilm'])->middleware([AuthMiddleware::class]);
    Route::post('wish-film/{film}',[UserController::class,'wishFilm'])->middleware([AuthMiddleware::class]);
    Route::delete('unwish-film/{film}',[UserController::class,'unwishFilm'])->middleware([AuthMiddleware::class]);
    Route::post('rate-film/{film}/{rating}',[UserController::class,'rateFilm'])->middleware([AuthMiddleware::class]);
    Route::post('comment-film/{film}',[UserController::class,'commentFilm'])->middleware([AuthMiddleware::class]);
});
