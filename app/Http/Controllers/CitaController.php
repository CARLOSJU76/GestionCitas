<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\Clientes;
use App\Models\Servicios;
use App\Models\Estados;
use App\Models\Horarios;
use App\Models\Vehiculo;


class CitaController extends Controller
{
//===========FUNCIÓN PARA MOSTRAR LA VISTA AL CREAR CITAS====================================================================================
    public function viewCreateCitas()
    {
       
        $clientes = Clientes::all();
        $servicios = Servicios::all();
        $estados = Estados::all();
        $horarios = Horarios::all();
        $vehiculos = Vehiculo::all();
       
        return view('gestionCitas.addCitas', compact('clientes', 'servicios', 'estados', 'horarios', 'vehiculos'));
    }
//===========FUNCIÓN PARA CREAR CITAS=====================================================================================
public function store(Request $request)
{
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'servicio_id' => 'required|exists:servicios,id',
        'horario_id' => 'required|exists:horarios,id',
        'vehiculo_id' => 'required|exists:vehiculos,id',
    ]);

    $cliente = Clientes::findOrFail($request->cliente_id);
    $servicio = Servicios::findOrFail($request->servicio_id);
    $horario = Horarios::findOrFail($request->horario_id);
    $vehiculo = Vehiculo::findOrFail($request->vehiculo_id);

    $estado_id = 1; // ← 🔥 Asignamos directamente estado_id en 1

    $cita = Citas::create([
        'cliente_id' => $cliente->id,
        'servicio_id' => $servicio->id,
        'estado_id' => $estado_id, // ← Usamos 1 aquí
        'horario_id' => $horario->id,
        'vehiculo_id' => $vehiculo->id, 
    ]);

    // Guardar en historial
    \App\Models\HistorialCitas::create([
        'cita_id' => $cita->id,
        'cliente_nombre' => $cliente->nombre,
        'servicio_nombre' => $servicio->nombre,
        'estado_nombre' => Estados::findOrFail($estado_id)->estado,
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
                    ->join('vehiculos', 'citas.vehiculo_id', '=', 'vehiculos.id')
                    ->select('citas.id as id', // Seleccionamos el id de la cita y lo aliasamos como "id"
                             'clientes.nombre as cliente_nombre', 
                             'servicios.nombre as servicio_nombre',
                             'estados.estado as estado',
                             'horarios.fecha_hora as fecha_hora',
                             'vehiculos.placa as vehiculo_placa')
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
    $citas = Citas::with(['cliente', 'horario', 'vehiculo'])->orderBy('horario_id', 'asc')->get();

    $clientes = Clientes::all();
    $servicios = Servicios::all();
    $estados = Estados::all();
    $vehiculos = Vehiculo::all();

    return view('gestioncitas.editar', compact('citas', 'clientes', 'servicios', 'estados', 'vehiculos'));
}
//===================función para actualizar citas=========================================================
public function update(Request $request, $id)
{
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'servicio_id' => 'required|exists:servicios,id',
      
        'horario_id' => 'required|exists:horarios,id',
        'vehiculo_id' => 'required|exists:vehiculos,id', 
    ]);

    $cita = Citas::findOrFail($id);
    $horarioAnteriorId = $cita->horario_id;

    // Buscar datos actualizados
    $cliente = Clientes::findOrFail($request->cliente_id);
    $servicio = Servicios::findOrFail($request->servicio_id);
  
    $nuevoHorario = Horarios::findOrFail($request->horario_id);
    $vehiculo = Vehiculo::findOrFail($request->vehiculo_id);

    // Actualizar la cita
    $cita->update([
        'cliente_id' => $cliente->id,
        'servicio_id' => $servicio->id,
      
        'horario_id' => $nuevoHorario->id,
        'vehiculo_id' => $vehiculo->id, 
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
        'vehiculo_id' => $cita->vehiculo_id,
    ]);
}
public function editCitas()
{
    $usuario_id = session('usuario_id'); // 👈 Obtenemos el usuario que está en sesión

    $citas = Citas::where('cliente_id', $usuario_id)
                  ->with(['cliente', 'horario'])
                  ->get();

    $clientes = Clientes::where('id', $usuario_id)->get(); // 👈 Solo el cliente logueado
    $servicios = Servicios::all();
    $estados = Estados::all();

    return view('gestioncitas.editMyCita', compact('citas', 'clientes', 'servicios', 'estados'));
}


}
