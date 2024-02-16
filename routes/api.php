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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/users',[ApiController::class, 'users']); //para obtener una lista de usuarios
Route::get('/validateUser',[ApiController::class, 'validateUser']); //para obtener una lista de usuarios
Route::post('/user/registry',[ApiController::class, 'registry']); //para obtener una lista de usuarios
Route::post('/login',[ApiController::class, 'login']); //para obtener el token que permitira acceder
