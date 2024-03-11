<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ReservaControlador;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Correspondientes rutas get, post, put y delete hacia el controlador ReservaControlador
//con métodos a los que accederá y tratará Postman 
Route::get('/res',[ReservaControlador::class,'consultarReserva'])->name('reservaJSON');

//mostramos en React las reservas disponibles 
Route::get('/reservasDisppp',[ReservaControlador::class,'reservasDisponibles']);

//datos de las reservas de un usuario
Route::get('/misReservas',[ReservaControlador::class,'misReservas']);
Route::delete('/deleteReserva',[ReservaControlador::class,'deleteReserva']);

//Obtener datos del user
Route::post('/getDatos',[ReservaControlador::class,'getDatos']);

Route::post('/crearTarjeta',[ReservaControlador::class,'crearTarjeta']);
Route::get('/misTarjetas',[ReservaControlador::class,'misTarjetas']);
Route::delete('/eliminarTarjeta',[ReservaControlador::class,'eliminarTarjeta']);




Route::post('/reservaUsuario', [ReservaControlador::class,'reservaUsuario']);

Route::post('/reservas',[ReservaControlador::class,'insertarReserva']);
Route::put('/reservas',[ReservaControlador::class,'actualizarReserva']);
Route::delete('/reservas/{id}',[ReservaControlador::class,'eliminarReserva']);


//Se registra correctamente
Route::post('/register',[AuthController::class,'createUser']);
//Se loguea correctamente
Route::post('/login',[AuthController::class,'loginUser']);

Route::get('/consultarReservaAuth', [ReservaControlador::class,'consultarReservaAuth'])->middleware('auth:sanctum');
Route::post('/reservas',[ReservaControlador::class,'insertarReservaAuth'])->middleware('auth:sanctum');;
Route::delete('/reservas/{id}',[ReservaControlador::class,'eliminarReservaAuth'])->middleware('auth:sanctum');;