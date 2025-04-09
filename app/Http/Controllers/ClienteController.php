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
    
    public function viewCliente(){

        $clientes= Clientes::all();

        return view('gestioncitas.clientes', compact('clientes'));
    }
    public function deleteCliente($id)
    {
        $cliente= Clientes::find($id);
        //dd($producto);
        if(! $cliente){
            return redirect()->route('clientes',  ['id' => $id])->with('error', 'Este Servicio no fue  encontrado.');
        }
        $cliente->delete();
        return redirect()->route('clientes',  ['id' => $id])->with('success', 'El Servicio ha sido excluido de la Base de Datos');
    }
}
