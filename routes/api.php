<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\RutaController;
use App\Http\Controllers\Api\FotoRutaController;
use App\Http\Controllers\Api\ItinerarioController;
use App\Http\Controllers\Api\ComentarioController;
use App\Http\Controllers\Api\GuiaController;
use App\Http\Controllers\Api\FotoGuiaController;
use App\Http\Controllers\Api\ClientePotencialController;
use App\Http\Controllers\Api\TipoFiltroController;
use App\Http\Controllers\Api\FiltroController;
use App\Http\Controllers\Api\FiltroRutasController;
use App\Http\Controllers\Api\ExternalApis;


// Usuarios
Route::post('/usuarios/register', [UsuarioController::class, 'register']);
Route::post('/usuarios/login', [UsuarioController::class, 'login']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);

// Rutas
Route::get('/rutas', [RutaController::class, 'index']);
Route::get('/rutas/{id}', [RutaController::class, 'show']);
Route::post('/rutas', [RutaController::class, 'store']);
Route::put('/rutas/{id}', [RutaController::class, 'update']);
Route::delete('/rutas/{id}', [RutaController::class, 'destroy']);

// FotoRutas
Route::get('/rutas/{id}/fotos', [FotoRutaController::class, 'index']);
Route::post('/rutas/{id}/fotos', [FotoRutaController::class, 'store']);
Route::put('/rutas/fotos/{id}', [FotoRutaController::class, 'update']);
Route::delete('/rutas/{id}/fotos/{fotoId}', [FotoRutaController::class, 'destroy']);

// Itineraios
Route::get('/rutas/{id}/itinerarios', [ItinerarioController::class, 'index']);
Route::post('/rutas/{id}/itinerarios', [ItinerarioController::class, 'store']);
Route::put('/itinerarios/{id}', [ItinerarioController::class, 'update']);
Route::delete('/itinerarios/{id}', [ItinerarioController::class, 'destroy']);

// Comentarios
Route::get('/rutas/{id}/comentarios', [ComentarioController::class, 'index']);
Route::post('/rutas/{id}/comentarios', [ComentarioController::class, 'store']);
Route::delete('/comentarios/{id}', [ComentarioController::class, 'destroy']);

// Filtro rutas
Route::get('/filtros/{id}/rutas', [FiltroRutasController::class, 'index']);
Route::post('/filtros/rutas', [FiltroRutasController::class, 'store']);
Route::delete('/filtros/{id}/rutas/{idr}', [FiltroRutasController::class, 'destroy']);

// TipoFiltro
Route::get('/tipos-filtro', [TipoFiltroController::class, 'index']);
Route::get('/tipos-filtro/{id}', [TipoFiltroController::class, 'show']);
Route::post('/tipos-filtro', [TipoFiltroController::class, 'store']);
Route::put('/tipos-filtro/{id}', [TipoFiltroController::class, 'update']);
Route::delete('/tipos-filtro/{id}', [TipoFiltroController::class, 'destroy']);

// TipoFiltro
Route::get('/filtro/{id}', [FiltroController::class, 'show']);
Route::post('/filtro', [FiltroController::class, 'store']);
Route::put('/filtro/{id}', [FiltroController::class, 'update']);
Route::delete('/filtro/{id}', [FiltroController::class, 'destroy']);

// Guias
Route::get('/guias', [GuiaController::class, 'index']);
Route::get('/guias/{id}', [GuiaController::class, 'show']);
Route::post('/guias', [GuiaController::class, 'store']);
Route::put('/guias/{id}', [GuiaController::class, 'update']);
Route::delete('/guias/{id}', [GuiaController::class, 'destroy']);

// FotoGuias
Route::get('/guias/{id}/fotos', [FotoGuiaController::class, 'index']);
Route::post('/guias/{id}/fotos', [FotoGuiaController::class, 'store']);
Route::put('/guias/fotos/{id}', [FotoGuiaController::class, 'update']);
Route::delete('/guias/fotos/{id}', [FotoGuiaController::class, 'destroy']);

//ClientesPotenciales
Route::get('/clientes-potenciales', [ClientePotencialController::class, 'index']);
Route::get('/clientes-potenciales/{id}', [ClientePotencialController::class, 'show']);
Route::post('/clientes-potenciales', [ClientePotencialController::class, 'store']);
Route::put('/clientes-potenciales/{id}', [ClientePotencialController::class, 'update']);

//ApisExternas
Route::get('/hora-beijing', [ExternalApis::class, 'obtenerHoraBeijing']);
Route::post('/ask-gemini', [ExternalApis::class, 'preguntar']);
//Prube con Proxies
// Route::get('/test-proxy', function () {
//     return response()->json([
//         'status' => 'Proxy funcionando correctamente',
//         'time' => now()
//     ]);
// });