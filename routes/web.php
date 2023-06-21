<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EntradasalidaCrudController;
use App\Http\Controllers\Admin\VehiculosCrudController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('admin/entradasalida/{id}/registrar-salida', [EntradasalidaCrudController::class, 'registrarSalida'])->name('admin.entradasalida.registrar_salida');
Route::get('admin/vehiculos/{id}/comienza-mes', [VehiculosCrudController::class, 'comienzaMes'])->name('admin.vehiculos.comienza_mes');
// Route::get('entradasalida/registrar_salida/{id}', [EntradaSalidaController::class, 'registrarSalida'])->name('admin.entradasalida.registrar_salida');

