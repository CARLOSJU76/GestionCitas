<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicios;
class ServiciosController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|string|max:20',
        ]);

        // Crear el cliente
        $cliente = Servicios::create($validated);

        // Devolver respuesta (puede ser un redirect o JSON)
        return redirect()->route('addservicios')->with('success', 'Servicio insertado en BD exitosamente.');
    }
    public function viewServicios(){

        $servicios= Servicios::all();

        return view('gestioncitas.servicios', compact('servicios'));
    }
    public function deleteServicio($id)
    {
        $servicios= Servicios::find($id);
        //dd($producto);
        if(! $servicios){
            return redirect()->route('servicios',  ['id' => $id])->with('error', 'Datos del cliente no fueron encontrados');
        }
        $servicios->delete();
        return redirect()->route('servicios',  ['id' => $id])->with('success', 'Datos del cliente han sido excluidos de la Base de Datos');
    }
}
