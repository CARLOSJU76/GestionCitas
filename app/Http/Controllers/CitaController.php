<?php

namespace App\Http\Controllers;

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

}
