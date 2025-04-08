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
}
