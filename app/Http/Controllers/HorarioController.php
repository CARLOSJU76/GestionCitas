<?php

namespace App\Http\Controllers;

use App\Models\Servicios;
use Illuminate\Http\Request;
use App\Models\Horarios;
use Illuminate\Database\QueryException;
class HorarioController extends Controller
{
    

public function store(Request $request)
{
    // Validar los datos
    $validated = $request->validate([
        'fecha_hora' => 'required|date',
        'servicio_id' => 'required|exists:servicios,id',
    ]);

    try {
        // Intentar crear el horario
        Horarios::create($validated);

        // Si todo va bien, redireccionar con éxito
        return redirect()->route('addHorarios')->with('success', 'Horario incluido en BD exitosamente.');
        
    } catch (QueryException $e) {
        // Verificar si el error fue por clave única duplicada (código 23000 en MySQL/MariaDB)
        if ($e->getCode() == 23000) {
            return redirect()->route('addHorarios')->with('error', 'Ya existe un horario con ese servicio y fecha.');
        }

        // En caso de otro error no controlado, puedes re-lanzar la excepción o manejarlo diferente
        throw $e;
    }
}

    public function viewAddHorario()
    {
       
        $servicios = Servicios::all();
        

        return view('gestionCitas.addHorarios', compact( 'servicios'));
    }
}
