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
}
