<?php

namespace App\Http\Controllers;

use App\Models\Horarios;
use App\Models\Servicios;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HorarioController extends Controller
{
    // Mostrar todos los horarios agrupados por servicio y fecha
    public function index(Request $request)
{
    $servicio_id = $request->get('servicio_id');
    //dd($servicio_id);

    $servicios = Servicios::all();

    // Si se filtró por servicio
    $horarios = Horarios::with('servicio')
        ->when($servicio_id, fn($query) => $query->where('servicio_id', $servicio_id))
        ->orderBy('fecha_hora')
        ->get()
        ->groupBy(function($horario) {
            return \Carbon\Carbon::parse($horario->fecha_hora)->format('Y-m-d');
        });

    return view('gestioncitas.horarios', compact('horarios', 'servicios', 'servicio_id'));
}


    // Mostrar formulario para crear nuevo horario
    public function create()
    {
        $servicios = Servicios::all();
        return view('gestionCitas.createHorario', compact('servicios'));
    }

    // Guardar horario nuevo
    public function store(Request $request)
    {
        $request->validate([
            'fecha_hora' => 'required|date',
            'servicio_id' => 'required|exists:servicios,id',
        ]);

        Horarios::create($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente');
    }

    // Mostrar formulario para editar un horario
    public function edit($id)
    {
        $horario = Horarios::findOrFail($id);
        $servicios = Servicios::all();

        return view('gestioncitas.editHorario', compact('horario', 'servicios'));
    }

    // Actualizar horario
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_hora' => 'required|date',
            'servicio_id' => 'required|exists:servicios,id',
        ]);

        $horario = Horarios::findOrFail($id);
        $horario->update($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente');
    }

    // Eliminar horario
    public function destroy($id)
    {
        $horario = Horarios::findOrFail($id);
        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente');
    }
  

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'dias' => 'required|array',
            'horas' => 'required|array',
        ]);
    
        $inicio = \Carbon\Carbon::parse($request->fecha_inicio);
        $fin = \Carbon\Carbon::parse($request->fecha_fin);
        $diasSeleccionados = array_map('intval', $request->dias);
        $horariosAgregados = 0;
    
        while ($inicio <= $fin) {
            if (in_array($inicio->dayOfWeek, $diasSeleccionados)) {
                foreach ($request->horas as $hora) {
                    $fechaHora = $inicio->format('Y-m-d') . ' ' . $hora;
    
                    // ⚠ Verifica si ya existe
                    $existe = Horarios::where('servicio_id', $request->servicio_id)
                                      ->where('fecha_hora', $fechaHora)
                                      ->exists();
    
                    if (!$existe) {
                        Horarios::create([
                            'servicio_id' => $request->servicio_id,
                            'fecha_hora' => $fechaHora,
                        ]);
                        $horariosAgregados++;
                    }
                }
            }
            $inicio->addDay();
        }
    
        if ($horariosAgregados === 0) {
            return redirect()->route('horarios.index')
                ->with('success', 'No se agregaron nuevos horarios porque ya existen.');
        }
    
        return redirect()->route('horarios.index')
            ->with('success', "$horariosAgregados horario(s) asignado(s) exitosamente.");
    }
    
}
