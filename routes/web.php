<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/bienvenida', function (){
    return view('gestionCitas.bienvenida');
});
Route::get('/clientes', function (){
    return view('gestionCitas.clientes');
});
Route::get('/agregar', function (){
    return view('gestionCitas.inserCliente');
});
Route::get('/actualizar', function (){
    return view('gestionCitas.updateClientes');
});
Route::get('/servicios', function (){
    return view('gestionCitas.servicios');
});
Route::get('/addservicios', function (){
    return view('gestionCitas.addservicios');
});
Route::get('/updateservicios', function (){
    return view('gestionCitas.updateservicios');
});
Route::get('/Citas', function (){
    return view('gestionCitas.citas');
});
Route::get('/addCitas', function (){
    return view('gestionCitas.addCitas');
});
Route::get('/updateCitas', function (){
    return view('gestionCitas.updateCitas');
});
