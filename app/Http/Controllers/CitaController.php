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
    

}
