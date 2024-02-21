<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// devuelve todos los usuarios
Route::get('/users',[ApiController::class, 'users']);
// devuelve un usuario
Route::get('/user',[ApiController::class, 'user']);
// post de login
Route::post('/user/login',[ApiController::class, 'login']);
// registra un usuario
Route::post('/user/registry',[ApiController::class, 'registry']);

