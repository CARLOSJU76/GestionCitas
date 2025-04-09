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
            return redirect()->route('clientes',  ['id' => $id])->with('error', 'no se encontraron datos del cliente.');
        }
        $cliente->delete();
    } 
    public function update(Request $request, $id)
    {
        // Validar los datos que vienen en la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
        ]);

        // Buscar el cliente
        $clientes = Clientes::findOrFail($id);

        // Actualizar los campos
        $clientes->nombre = $request->input('nombre');
        $clientes->telefono = $request->input('telefono');

        // Guardar los cambios
        $clientes->save();
        
        return redirect()->route('actualizar', ['id' => $id])->with('success', 
        'Información actulizada en BD exitosamente.');
    }
    public function getCliente($id)
{
    $cliente = Clientes::findOrFail($id);
    return response()->json($cliente);
}
public function ajaxEditView()
{
    $clientes = Clientes::all();
    return view('gestionCitas/updateClientes', compact('clientes'));
}


}  
        

