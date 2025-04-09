<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\CitaController;
use App\Models\Clientes;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/bienvenida', function (){
    return view('gestionCitas.bienvenida');
});
Route::get('/clientes', [ClienteController::class, 'viewCliente'])->name('clientes');
Route::delete('/deleteCliente/{id}', [ClienteController::class,'deleteCliente'])->name('deleteCliente');
//=======================================================================
Route::get('/agregar', function (){
    return view('gestionCitas.inserCliente');
});
Route::post('/agregar', [ClienteController::class, 'store'])->name('agregar');
//=======================================================================
Route::get('/actualizar', function (){
    return view('gestionCitas.updateClientes');
});
//=======================================================================
Route::get('/servicios', [ServiciosController::class, 'viewServicios'])->name('servicios');
Route::delete('/deleteServicio/{id}', [ServiciosController::class,'deleteServicio'])->name('deleteServicio');
//=======================================================================
Route::get('/addservicios', function (){
    return view('gestionCitas.addservicios');
});
Route::post('/addservicios', [ServiciosController::class, 'store'])->name('addservicios');
//=======================================================================
Route::get('/updateservicios', function (){
    return view('gestionCitas.updateservicios');
});
Route::get('/Citas', [CitaController::class, 'viewCitas'])->name('citas');
Route::delete('/deleteCita/{id}', [CitaController::class,'deleteCita'])->name('deleteCita');

//=======================================================================
Route::get('/addCitas', [CitaController::class, 'viewCreateCitas']);

Route::post('/addCitas', [CitaController::class, 'store'])->name('addCitas');
//========================================================================
Route::get('/updateCitas', function (){
    return view('gestionCitas.updateCitas');
});
