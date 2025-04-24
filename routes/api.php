<?php
// routes/api.php

use App\Http\Controllers\CitaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HorariosController;
use App\Http\Controllers\CitaControllerController;

Route::get('/horarios', [HorariosController::class, 'getHorariosPorServicio']);
