<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\Clientes;
use App\Models\Servicios;
use App\Models\Estados;
use App\Models\Horarios;

class CitaController extends Controller
{
//===========FUNCIÓN PARA MOSTRAR LA VISTA AL CREAR CITAS====================================================================================
    public function viewCreateCitas()
    {
       
        $clientes = Clientes::all();
        $servicios = Servicios::all();
        $estados = Estados::all();
        $horarios = Horarios::all();
       
        return view('gestionCitas.addCitas', compact('clientes', 'servicios', 'estados', 'horarios'));
    }
//===========FUNCIÓN PARA CREAR CITAS=====================================================================================
public function store(Request $request)
{
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'servicio_id' => 'required|exists:servicios,id',
        'estado_id' => 'required|exists:estados,id',
        'horario_id' => 'required|exists:horarios,id',
    ]);

    $cliente = Clientes::findOrFail($request->cliente_id);
    $servicio = Servicios::findOrFail($request->servicio_id);
    $estado = Estados::findOrFail($request->estado_id);
    $horario = Horarios::findOrFail($request->horario_id);

    $cita = Citas::create([
        'cliente_id' => $cliente->id,
        'servicio_id' => $servicio->id,
        'estado_id' => $estado->id,
        'horario_id' => $horario->id,
    ]);

    // Guardar en historial
    \App\Models\HistorialCitas::create([
        'cita_id' => $cita->id,
        'cliente_nombre' => $cliente->nombre,
        'servicio_nombre' => $servicio->nombre,
        'estado_nombre' => $estado->estado,
        'fecha_hora' => $horario->fecha_hora,
    ]);

    // Marcar horario como no disponible
    Horarios::where('id', $request->horario_id)->update(['disponible' => 0]);

    return redirect()->route('addCitas')->with('success', 'Cita registrada correctamente.');
}

//=============FUNCIÓN PARA VER TODOS LOS REGISTROS DE LAS CITAS===================================================================================
    public function viewCitas()
    {
        // Realizamos la consulta con los INNER JOIN para obtener los datos
        $citas = DB::table('citas')
                    ->join('clientes', 'citas.cliente_id', '=', 'clientes.id')
                    ->join('servicios', 'citas.servicio_id', '=', 'servicios.id')
                    ->join('estados', 'citas.estado_id', '=', 'estados.id')
                    ->join('horarios', 'citas.horario_id', 'horarios.id' )
                    ->select('citas.id as id', // Seleccionamos el id de la cita y lo aliasamos como "id"
                             'clientes.nombre as cliente_nombre', 
                             'servicios.nombre as servicio_nombre',
                             'estados.estado as estado',
                             'horarios.fecha_hora as fecha_hora')
                    ->get();
    
        // Pasamos los datos a la vista
        return view('gestioncitas.citas', compact('citas'));
    }
//=================FUNCIÓN PARA BORRAR LAS CITAS===============================================================================
public function deleteCita($id)
{
    $cita = Citas::find($id);

    if (!$cita) {
        return redirect()->route('citas', ['id' => $id])
                         ->with('error', 'Los datos de esta cita no fueron encontrados.');
    }

    // 1. Recuperar el horario_id antes de eliminar la cita
    $horarioId = $cita->horario_id;

    // 2. Eliminar la cita
    $cita->delete();

    // 3. Actualizar el campo 'disponible' del horario
    Horarios::where('id', $horarioId)->update(['disponible' => 1]);

    return redirect()->route('citas', ['id' => $id])
                     ->with('success', 'La Cita ha sido eliminada de la Base de Datos y el horario liberado.');
}
//==================FUCNCIÓN PARA LLEGAR A LA VISTA EDITAR=============================================================================
public function editView()
{
    $citas = Citas::with(['cliente', 'horario'])->orderBy('horario_id', 'asc')->get();

    $clientes = Clientes::all();
    $servicios = Servicios::all();
    $estados = Estados::all();

    return view('gestioncitas.editar', compact('citas', 'clientes', 'servicios', 'estados'));
}
//===================función para actualizar citas=========================================================
public function update(Request $request, $id)
{
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'servicio_id' => 'required|exists:servicios,id',
        'estado_id' => 'required|exists:estados,id',
        'horario_id' => 'required|exists:horarios,id',
    ]);

    $cita = Citas::findOrFail($id);
    $horarioAnteriorId = $cita->horario_id;

    // Buscar datos actualizados
    $cliente = Clientes::findOrFail($request->cliente_id);
    $servicio = Servicios::findOrFail($request->servicio_id);
    $estado = Estados::findOrFail($request->estado_id);
    $nuevoHorario = Horarios::findOrFail($request->horario_id);

    // Actualizar la cita
    $cita->update([
        'cliente_id' => $cliente->id,
        'servicio_id' => $servicio->id,
        'estado_id' => $estado->id,
        'horario_id' => $nuevoHorario->id,
    ]);

    // Actualizar disponibilidad de horarios
    if ($horarioAnteriorId != $request->horario_id) {
        Horarios::where('id', $horarioAnteriorId)->update(['disponible' => 1]);
        Horarios::where('id', $request->horario_id)->update(['disponible' => 0]);
    }

    // ✅ Actualizar historial
    \App\Models\HistorialCitas::updateOrCreate(
        ['cita_id' => $cita->id], // condición para encontrar el registro
        [ // valores a actualizar
            'cliente_nombre' => $cliente->nombre,
            'servicio_nombre' => $servicio->nombre,
            'estado_nombre' => $estado->estado,
            'fecha_hora' => $nuevoHorario->fecha_hora,
        ]
    );

    return redirect()->route('addCitas')->with('success', 'Cita actualizada correctamente.');
}
public function getCita($id)
{
    $cita = Citas::with('horario')->findOrFail($id);

    return response()->json([
        'id' => $cita->id,
        'cliente_id' => $cita->cliente_id,
        'servicio_id' => $cita->servicio_id,
        'estado_id' => $cita->estado_id,
        'horario_id' => $cita->horario_id,
        'fecha_hora' => $cita->horario->fecha_hora, // 👈 aquí está la clave
    ]);
}

}
