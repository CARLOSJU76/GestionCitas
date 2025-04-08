<?php

namespace App\Http\Controllers;
use App\Models\Clientes;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
        ]);

        // Crear el cliente
        $cliente = Clientes::create($validated);

        // Devolver respuesta (puede ser un redirect o JSON)
        return redirect()->route('agregar')->with('success', 'Cliente incluido en BD exitosamente.');
    }
}
