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
//=========================================================================================================
public function updateServicio(Request $request, $id)
{
    // Validar los datos que vienen en la solicitud
    $request->validate([
        'nombre' => 'required|string|max:255',
        'precio' => 'required|string|max:20',
    ]);

    // Buscar el cliente
    $servicios = Servicios::findOrFail($id);

    // Actualizar los campos
    $servicios->nombre = $request->input('nombre');
    $servicios->precio = $request->input('precio');

    // Guardar los cambios
    $servicios->save();
    
    return redirect()->route('updateservicios', ['id' => $id])->with('success', 
    'Información del Servicio ha sido actualizada en BD exitosamente.');
}
public function getServicio($id)
{
$servicios = Servicios::findOrFail($id);
return response()->json($servicios);
}
public function ajaxEditView()
{
$servicios = Servicios::all();
return view('gestionCitas/updateservicios', compact('servicios'));
}

//=========================================================================================================
}
