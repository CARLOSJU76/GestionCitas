<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Clientes;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::with('cliente')->get();
        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        $clientes = Clientes::all();
        return view('vehiculos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|unique:vehiculos,placa',
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        Vehiculo::create($request->all());

        return redirect()->route('vehiculos.index')->with('success', 'Vehículo registrado exitosamente.');
    }

    public function destroy($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->delete();

        return redirect()->route('vehiculos.index')->with('success', 'Vehículo eliminado exitosamente.');
    }
    public function getVehiculoPorCliente(Request $request)
    {
        // Obtener los horarios según el servicio_id
        if ($request->ajax()) {
    
            $vehiculos = Vehiculo::where('cliente_id', $request->cliente_id)
            ->get();
    
            // Devolver los horarios en formato JSON
            return response()->json([
                'vehiculos' => $vehiculos
            ]);
        }
    }
    public function createMyCar()
    {
        $clienteId = session('usuario_id');
    
        $vehiculos = Vehiculo::where('cliente_id', $clienteId)->get();
    
        return view('vehiculos.storeMyCar', compact('vehiculos'));
    }
    
    

public function storeMyCar(Request $request)
{
    $request->validate([
        'placa' => 'required|string|max:10|unique:vehiculos,placa',
    ]);

    // Recuperamos el cliente_id guardado en sesión
    $clienteId = session('usuario_id');

Vehiculo::create([
        'placa' => $request->placa,
        'cliente_id' => $clienteId,
    ]);

    return redirect()->route('createMyCar')->with('success', 'Vehículo registrado correctamente.');
}
public function destroyMyCar($id)
{
    $clienteId = session('usuario_id');

    // Asegurarse de que el vehículo pertenece al cliente
    $vehiculo = Vehiculo::where('id', $id)
                ->where('cliente_id', $clienteId)
                ->firstOrFail();

    $vehiculo->delete();

    return redirect()->route('createMyCar')->with('success', 'Vehículo eliminado exitosamente.');
}


    
}
