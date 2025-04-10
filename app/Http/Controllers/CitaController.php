<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\Clientes;
use App\Models\Servicios;
use App\Models\Estados;

class CitaController extends Controller
{
    public function viewCreateCitas()
    {
        $clientes = Clientes::all();
        $servicios = Servicios::all();
        $estados = Estados::all();

        return view('gestionCitas.addCitas', compact('clientes', 'servicios', 'estados'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servicio_id' => 'required|exists:servicios,id',
            'estado_id' => 'required|exists:estados,id',
            'fecha_hora' => 'required|date',
        ]);

        Citas::create($request->all());

        return redirect()->route('addCitas')->with('success', 'Cita registrada correctamente.');
    }

    public function viewCitas()
    {
        // Realizamos la consulta con los INNER JOIN para obtener los datos
        $citas = DB::table('citas')
                    ->join('clientes', 'citas.cliente_id', '=', 'clientes.id')
                    ->join('servicios', 'citas.servicio_id', '=', 'servicios.id')
                    ->join('estados', 'citas.estado_id', '=', 'estados.id')
                    ->select('citas.id as id', // Seleccionamos el id de la cita y lo aliasamos como "id"
                             'clientes.nombre as cliente_nombre', 
                             'servicios.nombre as servicio_nombre',
                             'estados.estado as estado',
                             'citas.fecha_hora')
                    ->get();
    
        // Pasamos los datos a la vista
        return view('gestioncitas.citas', compact('citas'));
    }
    
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
    public function updateCita(Request $request, $id)
{
    // Validar los datos que vienen en la solicitud
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
            'servicio_id' => 'required|exists:servicios,id',
            'estado_id' => 'required|exists:estados,id',
            'fecha_hora' => 'required|date',
    ]);

    // Buscar el cliente
    $citas = Citas::findOrFail($id);

    // Actualizar los campos
    $citas->cliente_id = $request->input('cliente_id');
    $citas->servicio_id= $request->input('servicio_id');
    $citas->estado_id= $request->input('estado_id');
    $citas->fecha_hora= $request->input('fecha_hora');

    // Guardar los cambios
    $citas->save();
    
    return redirect()->route('updateservicios', ['id' => $id])->with('success', 
    'Información del Servicio ha sido actualizada en BD exitosamente.');
}
public function getCita($id)
{
$citas = Citas::findOrFail($id);
return response()->json($citas);
}
public function ajaxEditView()
{
    // Traemos las citas con la información de cliente, servicio y estado
    $citas = DB::table('citas')
        ->join('clientes', 'citas.cliente_id', '=', 'clientes.id')
        ->join('servicios', 'citas.servicio_id', '=', 'servicios.id')
        ->join('estados', 'citas.estado_id', '=', 'estados.id')
        ->select('citas.id as id', 
                 'clientes.nombre as cliente_nombre', 
                 'servicios.nombre as servicio_nombre',
                 'estados.estado as estado',
                 'citas.fecha_hora',
                 'citas.cliente_id',
                 'citas.servicio_id',
                 'citas.estado_id')
        ->get();

    // Traemos todos los clientes, servicios y estados para los selects
    $clientes = DB::table('clientes')->get();
    $servicios = DB::table('servicios')->get();
    $estados = DB::table('estados')->get();

    // Pasamos los datos a la vista
    return view('gestionCitas/updateCitas', compact('citas', 'clientes', 'servicios', 'estados'));
}


}
