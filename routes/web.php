<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\HorarioController;
use App\Models\Clientes;

Route::get('/', function () {
    return view('welcome');
});
//====================BIENVENIDA========================================================
Route::get('/bienvenida', function (){
    return view('gestionCitas.bienvenida');
});
//======================================================================================
//====================CLIENTES==========================================================
Route::get('/clientes', [ClienteController::class, 'viewCliente'])->name('clientes');
Route::delete('/deleteCliente/{id}', [ClienteController::class,'deleteCliente'])->name('deleteCliente');
//======================================================================================
Route::get('/agregar', function (){
    return view('gestionCitas.inserCliente');
});
Route::post('/agregar', [ClienteController::class, 'store'])->name('agregar');
//=======================================================================================
// Muestra la vista con el select y el formulario
Route::get('/actualizar', [ClienteController::class, 'ajaxEditView'])->name('actualizar');

// Devuelve datos del cliente vía AJAX (JS lo usa)
Route::get('/api/clientes/{id}', [ClienteController::class, 'getCliente']);

// Actualiza el cliente (cuando se envía el formulario)
Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');

//=======================================================================================
//====================SERVICIOS==========================================================
Route::get('/servicios', [ServiciosController::class, 'viewServicios'])->name('servicios');
Route::delete('/deleteServicio/{id}', [ServiciosController::class,'deleteServicio'])->name('deleteServicio');
//=======================================================================================
Route::get('/addservicios', function (){
    return view('gestionCitas.addservicios');
});
Route::post('/addservicios', [ServiciosController::class, 'store'])->name('addservicios');
//=======================================================================================
Route::get('/updateservicios', [ServiciosController::class, 'ajaxEditView'])->name('updateservicios');

// Devuelve datos del cliente vía AJAX (JS lo usa)
Route::get('/api/servicios/{id}', [ServiciosController::class, 'getServicio']);

// Actualiza el cliente (cuando se envía el formulario)
Route::put('/serviciosupdate/{id}', [ServiciosController::class, 'updateServicio'])->name('servicios.update');

//======================================================================================
//====================CITAS=============================================================
Route::get('/Citas', [CitaController::class, 'viewCitas'])->name('citas');
Route::delete('/deleteCita/{id}', [CitaController::class,'deleteCita'])->name('deleteCita');

//=======================================================================================
Route::get('/addCitas', [CitaController::class, 'viewCreateCitas']);

Route::post('/addCitas', [CitaController::class, 'store'])->name('addCitas');
//=======================================================================================
Route::get('/updateCitas', [CitaController::class, 'ajaxEditView'])->name('updateCitas');

// Devuelve datos del cliente vía AJAX (JS lo usa)
Route::get('/api/citas/{id}', [CitaController::class, 'getCita']);

// Actualiza el cliente (cuando se envía el formulario)
Route::put('/citasupdate/{id}', [CitaController::class, 'updateCita'])->name('citas.update');
//==================HORARIOS===================================================================
Route::get('/horarios', function (){
    return view('gestionCitas.horarios');
});
Route::get('/addHorarios', [HorarioController::class, 'viewAddHorario']);
Route::post('/addHorarios', [HorarioController::class, 'store'])->name('addHorarios');