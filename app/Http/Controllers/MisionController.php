<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mision;

class MisionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
           'mision' => 'required|string|max:1000',  // Aumentar el límite a 1000 caracteres
        ]);

        Mision::create($request->all());

        return redirect()->route('mision.store')->with('success', 'Misión creada con éxito.');
    }
   public function index()
   {
       $mision = Mision::all();
       return view('mision.index', compact('mision'));
   }
   public function edit()
   {
       $mision = Mision::findOrFail(1); 
   
       return view('mision.edit', compact('mision'));
   }
   

public function update(Request $request)
{
    // Validar solo el campo 'mision'
    $request->validate([
        'mision' => 'required|string|max:1000',
    ]);

    // Obtener el único registro (ID fijo: 1)
    $mision = Mision::findOrFail(1);

    // Actualizar solo el campo 'mision'
    $mision->mision = $request->mision;
    $mision->save();

    return back()->with('success', 'Misión actualizada con éxito.');

    // Redirigir con mensaje de éxito
    
}

   

   
}
