<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\CitaController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/bienvenida', function (){
    return view('gestionCitas.bienvenida');
});
Route::get('/clientes', function (){
    return view('gestionCitas.clientes');
});
//=======================================================================
Route::get('/agregar', function (){
    return view('gestionCitas.inserCliente');
});
Route::post('/agregar', [ClienteController::class, 'store'])->name('agregar');
//=======================================================================
Route::get('/actualizar', function (){
    return view('gestionCitas.updateClientes');
});
Route::get('/servicios', function (){
    return view('gestionCitas.servicios');
});
//=======================================================================
Route::get('/addservicios', function (){
    return view('gestionCitas.addservicios');
});
Route::post('/addservicios', [ServiciosController::class, 'store'])->name('addservicios');
//=======================================================================
Route::get('/updateservicios', function (){
    return view('gestionCitas.updateservicios');
});
Route::get('/Citas', function (){
    return view('gestionCitas.citas');
});
//=======================================================================
Route::get('/addCitas', [CitaController::class, 'viewCreateCitas']);

Route::post('/addCitas', [CitaController::class, 'store'])->name('addCitas');

//========================================================================
Route::get('/updateCitas', function (){
    return view('gestionCitas.updateCitas');
});
