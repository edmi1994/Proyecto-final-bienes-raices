<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/propiedades',[App\Http\Controllers\PropiedadesController::class, 'index']);
Route::get('/propiedades/crear',[App\Http\Controllers\PropiedadesController::class, 'create']);
Route::any('/propiedades/store',[App\Http\Controllers\PropiedadesController::class, 'store']);
Route::any('/propiedades/destroy',[App\Http\Controllers\PropiedadesController::class, 'destroy']);
Route::any('/propiedades/registros',[App\Http\Controllers\PropiedadesController::class, 'listar_registros']);
Route::any('/propiedades/editar/{propiedad}',[App\Http\Controllers\PropiedadesController::class, 'edit']);
Route::any('/propiedades/actualizar/{id}',[App\Http\Controllers\PropiedadesController::class, 'update']);


Route::get('/clientes',[App\Http\Controllers\ClientesController::class, 'index']);
Route::get('/clientes/crear',[App\Http\Controllers\ClientesController::class, 'create']);
Route::any('/clientes/store',[App\Http\Controllers\ClientesController::class, 'store']);
Route::any('/clientes/destroy',[App\Http\Controllers\ClientesController::class, 'destroy']);
Route::any('/clientes/registros',[App\Http\Controllers\ClientesController::class, 'listar_registros']);
Route::any('/clientes/editar/{cliente}',[App\Http\Controllers\ClientesController::class, 'edit']);
Route::any('/clientes/actualizar/{id}',[App\Http\Controllers\ClientesController::class, 'update']);

Route::any('/filtros/propiedades',[App\Http\Controllers\PropiedadesController::class, 'filtros']);


Route::any('/ventas',[App\Http\Controllers\VentasController::class, 'index']);
Route::any('/ventas/crear',[App\Http\Controllers\VentasController::class, 'create']);
Route::any('/ventas/store',[App\Http\Controllers\VentasController::class, 'store']);
Route::any('/ventas/registros',[App\Http\Controllers\VentasController::class, 'listar_registros']);
Route::any('/ventas/anular',[App\Http\Controllers\VentasController::class, 'anular']);

Route::any('/reservas',[App\Http\Controllers\ReservasController::class, 'index']);
Route::any('/reservas/crear',[App\Http\Controllers\ReservasController::class, 'create']);
Route::any('/reservas/store',[App\Http\Controllers\ReservasController::class, 'store']);
Route::any('/reservas/registros',[App\Http\Controllers\ReservasController::class, 'listar_registros']);
Route::any('/reservas/anular',[App\Http\Controllers\ReservasController::class, 'anular']);


Route::any('/clientes/traer',[App\Http\Controllers\VentasController::class, 'clientes']);
Route::any('/propiedades/traer',[App\Http\Controllers\VentasController::class, 'propiedades']);



