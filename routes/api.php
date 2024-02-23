<?php

use App\Http\Controllers\ColorController;
use App\Http\Controllers\FavoriteController;
use App\Models\User;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*ruta que ya te viene generada*/

// === AUTH ===

// Crea un nuevo registro de usuario
Route::post('/user/registry',[ApiController::class, 'registry']);

// Login: Requiere 'email' y 'password'
Route::post('/user/login',[ApiController::class, 'login']);

// Devuelve el usuario activo dado un token
Route::middleware('auth:sanctum')->get('/user/current',[ApiController::class, 'currentUser']);

// Devuelve el usuario activo dado un token
Route::middleware('auth:sanctum')->get('/user/logout',[ApiController::class, 'logout']);



// === CRUD DE USUARIO ===

// devuelve todos los usuarios
Route::get('/users',[ApiController::class, 'users']);

// devuelve un usuario
Route::get('/user',[ApiController::class, 'user']);


// === CRUD DE COLORES (TODO: Incluir validacion por token) ===

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers'], function() {
   Route::apiResource('colors',ColorController::class);
});

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v1', 'namespace' => 'App\Http\Controllers'], function() {
    Route::apiResource('favorites',FavoriteController::class);
});
