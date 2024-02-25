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
    POST: localhost:8000/api/v1/register
    Payload:
    {
        "name": "Nombre Usuario",
        "email": "nuevo@usuario.com",
        "password": "mi_contraseña_segura"
    }
    */
    Route::post('register', [AuthController::class, 'register']);

    /* Accede al sistema y devuelve un token.
    POST: localhost:8000/api/v1/login
    Payload:
    {
        "email": "user@test.com",
        "password": "test_passwrd"
    }
    */
    Route::post('login', [AuthController::class, 'login']);

    /* Metodo auxiliar. Obtiene el nombre de un color dado su codigo HEX.
    GET: localhost:8000/api/v1/color/fa3232
    */
    Route::get('color/{hex}', [ColorController::class, 'findhex']);
});

// Metodos que requieren autenticacion via token.
// headers: { Authorization: `Bearer 9|oDYcViwIo5KjRpG8BWLfL6kQmiXMtwRI3hTN9Z8B5371571d` }

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v1', 'namespace' => 'App\Http\Controllers'], function () {

    /* Devuelve el usuario activo actual
    GET: localhost:8000/api/v1/user
    */
    Route::get('user', [AuthController::class, 'user']);

    /* Anula el token activo, terminando la sesion del usuario.
    GET: localhost:8000/api/v1/logout
    */
    Route::get('logout', [AuthController::class, 'logout']);

    // Recursos de 'favoritos'

    /* Obtener listado de favoritos del usuario activo
    GET: localhost:8000/api/v1/favorites
    */

    /* Crear un nuevo favorito, asociado a un codigo hex de color
    POST: localhost:8000/api/v1/favorites
    Payload:
    {
        "name": "Mi nuevo Color Favorito",
        "color_hex": "ffca45"
    }
    */

    /* Mostrar un favorito del usuario activo
    GET: localhost:8000/api/v1/favorites/109
    */

    /* Borrar un favorito del usuario activo
    DELETE: localhost:8000/api/v1/favorites/31
    */

    /* Edita un favorito del usuario activo
    PUT/PATCH: localhost:8000/api/v1/favorites/8
    Payload:
    {
        "name": "Nuevo nombre de Color Favorito"
    }
    */
    Route::apiResource('favorites', FavoriteController::class);

    // Recursos de 'proyectos'

    /* Obtener los proyectos del usuario activo
    GET: localhost:8000/api/v1/projects
    */

    /* Crear un proyecto, asociado al usuario activo
    POST: localhost:8000/api/v1/projects
    Payload:
    {
        "name": "Nombre del Proyecto",
        "description": "Descripcion del Proyecto"
    }
    */

    /* Mostrar un proyecto del usuario activo
    GET: localhost:8000/api/v1/projects/32

    /* Borrar un proyecto del usuario activo
    DELETE: localhost:8000/api/v1/projects/3
    */

    /* Edita un proyecto del usuario activo
    PUT/PATCH: localhost:8000/api/v1/projects/8
    Payload:
    {
        "name": "Mi nuevo Nombre de Proyecto",
        "description": "Mi nueva descripcion de proyecto"
    }
    */
    Route::apiResource('projects', ProjectController::class);

    // Recursos de 'paletas'

    /* Crear una paleta, asociada a un proyecto especifico
    POST: localhost:8000/api/v1/palettes
    Payload:
    {
        "name": "Mi Nueva Paleta",
        "project_id": 52
    }
    */
    Route::apiResource('palettes', PaletteController::class);

    /* Recursos de 'colores'
    GET: localhost:8000/api/v1/favorites
    */
    Route::apiResource('colors', ColorController::class);
});
