<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\HistorialCitas;
use App\Models\Clientes;
use Illuminate\Http\Request;

class HistorialCitasController extends Controller
{
  
public function mostrarFormulario(Request $request)
{
    // Obtener todos los clientes para el select
    $clientes = Clientes::all();

    // Si se seleccionó un cliente, filtramos los registros de historial_citas
    $historialCitas = collect(); // Inicializamos una colección vacía para los resultados

    if ($request->has('cliente_id')) {
        // Validar el cliente seleccionado
        $request->validate([
            'cliente_id' => 'required|exists:clientes,identificacion',
        ]);

        // Obtener el historial de citas para el cliente seleccionado
        $historialCitas = HistorialCitas::where('identificacion', $request->cliente_id)->get();
    }

    // Retornar la vista con los datos
    return view('gestioncitas.historial_form', compact('clientes', 'historialCitas'));
}
public function verMiHistorial()
{
    // Verificar que el usuario esté autenticado (exista en la sesión)
    if (!session()->has('usuario_identificacion')) {
        return redirect()->route('clientes.login.form')->withErrors(['mensaje' => 'Debe iniciar sesión para ver su historial.']);
    }

    // Obtener la identificación desde la sesión
    $identificacion = session('usuario_identificacion');

    // Buscar el historial de citas
    $historialCitas = HistorialCitas::where('identificacion', $identificacion)->get();

    // También puedes recuperar el nombre del cliente si quieres mostrarlo
    $cliente = Clientes::where('identificacion', $identificacion)->first();

    return view('gestioncitas.myHistorial', compact('historialCitas', 'cliente'));
}



    }
