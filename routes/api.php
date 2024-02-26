<?php

use App\Http\Controllers\ColorController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PaletteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
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

// Metodos que no requieren autenticacion

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers'], function () {

    /* Registra un nuevo usuario.
    POST: /api/v1/register
    Payload:
    {
        "name": "Nombre Usuario",
        "email": "nuevo@usuario.com",
        "password": "mi_contraseña_segura"
    }
    */
    Route::post('register', [AuthController::class, 'register']);

    /* Accede al sistema y devuelve un token.
    POST: /api/v1/login
    Payload:
    {
        "email": "user@test.com",
        "password": "test_password"
    }
    */
    Route::post('login', [AuthController::class, 'login']);

    /* Metodo auxiliar. Genera un color aleatorio.
    GET: /api/v1/colors/random
    */
    Route::get('colors/random', [ColorController::class, 'random']);

    /* Metodo auxiliar. Obtiene el nombre de un color dado su codigo HEX.
    GET: /api/v1/colors/fa3232
    */
    Route::apiResource('colors', ColorController::class);
});

// Metodos que requieren autenticacion via token.
// headers: { Authorization: `Bearer 9|oDYcViwIo5KjRpG8BWLfL6kQmiXMtwRI3hTN9Z8B5371571d` }

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v1', 'namespace' => 'App\Http\Controllers'], function () {

    /* Devuelve el usuario activo actual
    GET: /api/v1/user
    */
    Route::get('user', [AuthController::class, 'user']);

    /* Anula el token activo, terminando la sesion del usuario.
    GET: /api/v1/logout
    */
    Route::get('logout', [AuthController::class, 'logout']);

    // Recursos de 'favoritos'

    /* Obtener listado de favoritos del usuario activo
    GET: /api/v1/favorites
    */

    /* Crear un nuevo favorito, asociado a un codigo hex de color
    POST: /api/v1/favorites
    Payload:
    {
        "name": "Mi nuevo Color Favorito",
        "color_hex": "ffca45"
    }
    */

    /* Mostrar un favorito del usuario activo
    GET: /api/v1/favorites/109
    */

    /* Borrar un favorito del usuario activo
    DELETE: /api/v1/favorites/31
    */

    /* Edita un favorito del usuario activo
    PUT/PATCH: /api/v1/favorites/8
    Payload:
    {
        "name": "Nuevo nombre de Color Favorito"
    }
    */
    Route::apiResource('favorites', FavoriteController::class);

    // Recursos de 'proyectos'

    /* Obtener los proyectos del usuario activo
    GET: /api/v1/projects
    */

    /* Crear un proyecto, asociado al usuario activo
    POST: /api/v1/projects
    Payload:
    {
        "name": "Nombre del Proyecto",
        "description": "Descripcion del Proyecto"
    }
    */

    /* Mostrar un proyecto del usuario activo
    GET: /api/v1/projects/32

    /* Borrar un proyecto del usuario activo
    DELETE: /api/v1/projects/3
    */

    /* Edita un proyecto del usuario activo
    PUT/PATCH: /api/v1/projects/8
    Payload:
    {
        "name": "Mi nuevo Nombre de Proyecto",
        "description": "Mi nueva descripcion de proyecto"
    }
    */
    Route::apiResource('projects', ProjectController::class);

    // Recursos de 'paletas'

    /* Obtener las paletas del usuario activo
    GET: /api/v1/palettes
    */

    /* Crear una paleta, asociada a un proyecto especifico
    POST: /api/v1/palettes
    Payload:
    {
        "name": "Mi Paleta de Prueba",
        "project_id": 1,
        "colors": [
            {"hex": "000000"},
            {"hex": "444444"},
            {"hex": "888888"},
            {"hex": "BBBBBB"},
            {"hex": "FFFFFF"}
        ]
    }

    /* Mostrar una paleta del usuario activo
    GET: /api/v1/palettes/32

    /* Borrar una paleta del usuario activo
    DELETE: /api/v1/palettes/3
    */

    /* Edita una paleta del usuario activo
    PUT/PATCH: /api/v1/palettes/8
    Payload:
    {
        "name": "Mi nuevo Nombre de Paleta",
    }
    */
    Route::apiResource('palettes', PaletteController::class);
});
