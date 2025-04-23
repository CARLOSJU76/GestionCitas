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
    public function viewCreateCitas()
    {
       

        $clientes = Clientes::all();
        $servicios = Servicios::all();
        $estados = Estados::all();
        $horarios = Horarios::all();
       
        return view('gestionCitas.addCitas', compact('clientes', 'servicios', 'estados', 'horarios'));
    }
    public function store(Request $request)
    {
        
        // Validar los datos que vienen en la solicitud
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

        Citas::create([
            'cliente_id' => $cliente->id,
            'servicio_id' => $servicio->id,
            'estado_id' => $estado->id,
            'horario_id' => $horario->id,
            'cliente_nombre' => $cliente->nombre,
            'servicio_nombre' => $servicio->nombre,
            'estado_nombre' => $estado->estado,
            'fecha_hora' => $horario->fecha_hora,
        ]);

        Horarios::where('id', $request->horario_id)
        ->update(['disponible' => 0]);

        return redirect()->route('addCitas')->with('success', 'Cita registrada correctamente.');
    }
//================================================================================================
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
//================================================================================================
public function deleteCita($id)
    {
        $citas= Citas::find($id);
        //dd($producto);
        if(! $citas){
            return redirect()->route('citas',  ['id' => $id])->with('error', 'Los datos de esta cita no fueron encontrados.');
        }
        $citas->delete();
        return redirect()->route('citas',  ['id' => $id])->with('success', 'La Cita ha sido eliminada de la Base de Datos');
    }
//================================================================================================
    public function updateCita(Request $request, $id)
{
    // Validar los datos que vienen en la solicitud
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
            'servicio_id' => 'required|exists:servicios,id',
            'estado_id' => 'required|exists:estados,id',
            'horario_id' => 'required|exists:horarios,id',
    ]);

    // Buscar el cliente
    $citas = Citas::findOrFail($id);

    // Actualizar los campos
    $citas->cliente_id = $request->input('cliente_id');
    $citas->servicio_id= $request->input('servicio_id');
    $citas->estado_id= $request->input('estado_id');
    $citas->horario_id=$request->input('horario_id');
    // Guardar los cambios
    $citas->save();
    
    return redirect()->route('updateCitas', ['id' => $id])->with('success', 
    'Información del Servicio ha sido actualizada en BD exitosamente.');
}
//================================================================================================
public function getCita($id)
{
$citas = Citas::findOrFail($id);
return response()->json($citas);
}
//================================================================================================
public function ajaxEditView()
{
    $citas = DB::table('citas')
        ->join('clientes', 'citas.cliente_id', '=', 'clientes.id')
        ->select('citas.id', 'clientes.nombre as cliente_nombre')
        ->get();

    $clientes = DB::table('clientes')->get();
    $servicios = DB::table('servicios')->get();
    $estados = DB::table('estados')->get();

    return view('gestionCitas.updateCitas', compact('citas', 'clientes', 'servicios', 'estados'));
}
//================================================================================================
// En CitasController.php
public function show($id)
{
    $cita = DB::table('citas')
        ->join('clientes', 'citas.cliente_id', '=', 'clientes.id')
        ->join('servicios', 'citas.servicio_id', '=', 'servicios.id')
        ->join('estados', 'citas.estado_id', '=', 'estados.id')
        ->join('horarios', 'citas.horario_id', 'horarios.id')
        ->where('citas.id', $id)
        ->select(
            'citas.id',
            'citas.cliente_id',
            'citas.servicio_id',
            'citas.estado_id',
            'horarios.id as horario_id',
            'horarios.fecha_hora'
        )
        ->first();

    if (!$cita) {
        return response()->json(['error' => 'Cita no encontrada'], 404);
    }

    return response()->json($cita);
}



public function getHorariosPorServicio(Request $request)
{
    // Obtener los horarios según el servicio_id
    if ($request->ajax()) {
        $ahora = now(); // Fecha y hora actual

        $horarios = Horarios::where('servicio_id', $request->servicio_id)
        ->where('disponible', 1)
        ->where('fecha_hora', '>=', $ahora)
        ->orderBy('fecha_hora', 'asc')
        ->get();

        // Devolver los horarios en formato JSON
        return response()->json([
            'horarios' => $horarios
        ]);
    }
}
public function edit($id)
{
    // Traemos la cita específica por su ID
    $cita = DB::table('citas')
        ->join('clientes', 'citas.cliente_id', '=', 'clientes.id')
        ->join('servicios', 'citas.servicio_id', '=', 'servicios.id')
        ->join('estados', 'citas.estado_id', '=', 'estados.id')
        ->join('horarios', 'citas.horario_id', '=', 'horarios.id')
        ->select('citas.id as id',
                 'clientes.nombre as cliente_nombre',
                 'servicios.nombre as servicio_nombre',
                 'estados.estado as estado',
                 'horarios.fecha_hora as fecha_hora',
                 'horarios.id as horario_id',
                 'citas.cliente_id',
                 'citas.servicio_id',
                 'citas.estado_id')
        ->where('citas.id', $id)
        ->first();

    // Traemos todos los clientes, servicios, estados y horarios disponibles para los selects
    $clientes = DB::table('clientes')->get();
    $servicios = DB::table('servicios')->get();
    $estados = DB::table('estados')->get();
    $horarios = DB::table('horarios')->get();

    // Pasamos los datos a la vista
    return view('gestionCitas.updateCitas', compact('cita', 'clientes', 'servicios', 'estados', 'horarios'));
}



}
