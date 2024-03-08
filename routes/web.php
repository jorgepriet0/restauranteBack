<?php

use App\Http\Controllers\ReservaController;
use App\Models\Reserva;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CocheController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormularioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/misreservas', [ReservaController::class, 'misReservas'])->middleware(['auth', 'verified'])->name('misreservas');
Route::delete('/cancelarReserva',[ReservaController::class,'cancelarReserva'])->name('cancelarReserva');

//Ruta que obtiene la página contacto con la fecha y hora del evento
//Route::get('/confirmarReserva/{fecha}/{hora}', [FormularioController::class, 'index']);

Route::get('/reservaHecha', [FormularioController::class, 'SendEmail']);

Route::get('/confirmarReserva', [FormularioController::class,'SendEmail'])->name('confirmarReserva.SendMail');

Route::get('/prueba',[UserController::class,'index'])->name('prueba');
Route::get('/reservar',[ReservaController::class,'index'])->name('reservar');

