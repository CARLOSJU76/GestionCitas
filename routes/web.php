<?php

use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\HorariosController;
use App\Http\Controllers\HistorialCitasController;
use App\Http\Middleware\CheckPerfil;
use App\Http\Controllers\MisionController;
use App\Http\Controllers\VisionController;
use App\Models\Clientes;

Route::get('/', function () {
    return view('gestionCitas/login');
});
//====================BIENVENIDA========================================================
Route::get('/bienvenida1', function (){return view('gestionCitas.bienvenida1');})->middleware([CheckPerfil::class.':1'])->name('bienvenida1');
Route::get('/bienvenida2', function (){return view('gestionCitas.bienvenida2');})->middleware([CheckPerfil::class.':2'])->name('bienvenida2');
Route::get('/bienvenida3', function (){return view('gestionCitas.bienvenida3');})->middleware([CheckPerfil::class.':3'])->name('bienvenida3');
Route::get('/bienvenida4', function (){return view('gestionCitas.bienvenida4');})->middleware([CheckPerfil::class.':4'])->name('bienvenida4');
//======================================================================================
//====================CLIENTES==========================================================
Route::get('/clientes', [ClienteController::class, 'viewCliente'])->middleware([CheckPerfil::class.':2'])->name('clientes');
Route::delete('/clientes/{id}', [ClienteController::class,'deleteCliente'])->middleware([CheckPerfil::class.':2'])->name('deleteCliente');
//======================================================================================
Route::get('/agregar', function (){
    return view('gestionCitas.inserCliente');
});
Route::post('/agregar', [ClienteController::class, 'store'])->name('agregar');
//=======================================================================================
// Muestra la vista con el select y el formulario
Route::get('/actualizar', [ClienteController::class, 'ajaxEditView'])->middleware([CheckPerfil::class.':2'])->name('actualizar');

// Devuelve datos del cliente vía AJAX (JS lo usa)
Route::get('/api/clientes/{id}', [ClienteController::class, 'getCliente'])->middleware([CheckPerfil::class.':2']);

// Actualiza el cliente (cuando se envía el formulario)
Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');

//=======================================================================================
//====================SERVICIOS==========================================================
Route::get('/servicios', [ServiciosController::class, 'viewServicios'])->middleware([CheckPerfil::class.':4'])->name('servicios');
Route::delete('/deleteServicio/{id}', [ServiciosController::class,'deleteServicio'])->name('deleteServicio');
//=======================================================================================
Route::get('/addservicios', function (){
    return view('gestionCitas.addservicios');
})->middleware([CheckPerfil::class.':4']);
Route::post('/addservicios', [ServiciosController::class, 'store'])->name('addservicios');
//=======================================================================================
Route::get('/updateservicios', [ServiciosController::class, 'ajaxEditView'])->middleware([CheckPerfil::class.':4'])->name('updateservicios');

// Devuelve datos del cliente vía AJAX (JS lo usa)
Route::get('/api/servicios/{id}', [ServiciosController::class, 'getServicio']);

// Actualiza el cliente (cuando se envía el formulario)
Route::put('/serviciosupdate/{id}', [ServiciosController::class, 'updateServicio'])->name('servicios.update');

//======================================================================================
//====================CITAS=============================================================
Route::get('/citas', [CitaController::class, 'viewCitas'])->middleware([CheckPerfil::class.':2'])->name('citas');
Route::delete('/deleteCita/{id}', [CitaController::class,'deleteCita'])->name('deleteCita');

//=======================================================================================
Route::get('/addCitas', [CitaController::class, 'viewCreateCitas'])->middleware([CheckPerfil::class.':2']);

Route::post('/addCitas', [CitaController::class, 'store'])->name('addCitas');
//=======================================================================================
Route::get('/updateCitas', [CitaController::class, 'ajaxEditView'])->name('updateCitas');

Route::get('/api/citas/{id}', [CitaController::class, 'show']);

// Actualiza el cliente (cuando se envía el formulario)
Route::put('/citasupdate/{id}', [CitaController::class, 'updateCita'])->name('citas.update');
//==================HORARIOS===================================================================

Route::resource('horarios', HorariosController::class)->middleware([CheckPerfil::class.':3']);
Route::post('/horarios/multiple', [HorariosController::class, 'storeMultiple'])->name('horarios.storeMultiple');

//=============================================================================================

Route::get('/get-horarios-por-servicio', [HorariosController::class, 'getHorariosPorServicio'])->name('getHorariosPorServicio');

//===========Rutas para Actualizar Citas===================================================================================

Route::get('/citas/editar', [CitaController::class, 'editView'])->middleware([CheckPerfil::class.':2'])->name('citas.editView');
Route::get('/api/citas/{id}', [CitaController::class, 'getCita']);
// Ruta para obtener los horarios por servicio al actualizar el servicio
Route::get('/api/horarios', [HorariosController::class, 'getHorariosPorServicio']);
// Ruta para actualizar la cita
Route::put('/citasupdate/{id}', [CitaController::class, 'update'])->name('citas.update');
//=========================================================================================================================
use App\Http\Controllers\VehiculoController;

Route::resource('vehiculos', VehiculoController::class)->middleware([CheckPerfil::class.':2']);
Route::get('/get-vehiculo-por-cliente', [VehiculoController::class, 'getVehiculoPorCliente'])->name('getVehiculoPorCliente');
Route::get('/api/vehiculos', [VehiculoController::class, 'getVehiculoPorCliente']);
//==========================================================================================
use App\Http\Controllers\ClienteAuthController;

Route::get('/clientes.login.form', [ClienteAuthController::class, 'showLoginForm'])->name('clientes.login.form');
Route::post('clientes/login', [ClienteAuthController::class, 'login'])->name('clientes.login');
Route::post('/logout', [ClienteAuthController::class, 'logout'])->name('logout');

Route::get('/misDatos', [ClienteController::class, 'editPerfilCliente'])->middleware([CheckPerfil::class.':1'])->name('misDatos');
Route::get('/agendar', [ClienteController::class, 'showFormularioCita'])->middleware([CheckPerfil::class.':1'])->name('agendar');
Route::get('/verMisCitas', [CitaController::class, 'editCitas'])->middleware([CheckPerfil::class.':1'])->name('verMisCitas');
//====================Ruta para Historial de Citas=====================================================================
// Ruta para ver el historial de citas con el formulario de selección de cliente
Route::get('/historialCitas', [HistorialCitasController::class, 'mostrarFormulario'])->middleware([CheckPerfil::class.':2'])->name('historialCitas');
Route::get('/myHistorial', [HistorialCitasController::class, 'verMiHistorial'])->middleware([CheckPerfil::class.':1'])->name('myHistorial');
//====================Ruta para registrar vehiculo por cliente========================================================
Route::get('/createMyCar', [VehiculoController::class, 'createMyCar'])->middleware([CheckPerfil::class.':1'])->name('createMyCar');

Route::post('/storeMyCar', [VehiculoController::class, 'storeMyCar'])->name('storeMyCar');
Route::delete('/mis-vehiculos/{id}', [VehiculoController::class, 'destroyMyCar'])->name('destroyMyCar');
Route::get('/editarEstadoView', [CitaController::class, 'editarEstadoView'])->middleware([CheckPerfil::class.':3'])->name('editarEstadoView');
Route::put('citasestado/{id}', [CitaController::class, 'updateEstado'])->name('citasestado');
Route::get('/editPerfil', [ClienteController::class, 'editPerfil'])->middleware([CheckPerfil::class.':4'])->name('editPerfil');
Route::put('/clientes/{id}/perfil', [ClienteController::class, 'updatePerfil'])->name('clientes.updatePerfil');

Route::get('/mision/edit', [MisionController::class, 'edit'])->name('mision.edit');
Route::put('/mision', [MisionController::class, 'update'])->name('mision.update');
Route::get('/mision', [MisionController::class, 'index'])->name('mision.index');


Route::get('/vision', [VisionController::class, 'index'])->name('vision.index');

Route::get('/vision/edit', [VisionController::class, 'edit'])->name('vision.edit');
Route::put('/vision', [VisionController::class, 'update'])->name('vision.update');

Route::get('/editPassword', [ClienteController::class, 'editPassword'])->name('editPassword');
Route::put('/updatePassword', [ClienteController::class, 'updatePassword'])->name('updatePassword');

