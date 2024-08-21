<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RedirectIfAuth;

Route::get('/', [PageController::class,'home']);

Route::get('/films/{film:slug}',[PageController::class,'filmDetail'])->middleware([AuthMiddleware::class]);
Route::get('/myfilms',[PageController::class,'myfilms'])->middleware([AuthMiddleware::class]);
Route::get('/wishlist',[PageController::class,'wishlist'])->middleware([AuthMiddleware::class]);
Route::get('register',[PageController::class,'register'])->middleware([RedirectIfAuth::class]);
Route::get('login',[PageController::class,'login'])->middleware([RedirectIfAuth::class]);

Route::post('/add-user',[UserController::class,'store']);

Route::post('/login-be',[AuthController::class,'login']);
Route::get('/logout-be',[AuthController::class,'logout']);

Route::post('buy-film/{film}',[UserController::class,'buyFilm']);
Route::post('wish-film/{film}',[UserController::class,'wishFilm']);
Route::post('unwish-film/{film}',[UserController::class,'unwishFilm']);
Route::post('rate-film/{film}/{rating}',[UserController::class,'rateFilm']);
Route::post('comment-film/{film}',[UserController::class,'commentFilm']);
