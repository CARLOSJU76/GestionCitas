<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vision;

class VisionController extends Controller
{
    public function index()
   {
       $vision = Vision::all();
       return view('vision.index', compact('vision'));
   }
   public function edit()
   {
       $vision = Vision::findOrFail(1); 
   
       return view('vision.edit', compact('vision'));
   }
   public function update(Request $request)
{
    // Validar solo el campo 'vision'
    $request->validate([
        'vision' => 'required|string|max:1000',
    ]);

    // Obtener el único registro (ID fijo: 1)
    $vision = Vision::findOrFail(1);

    // Actualizar solo el campo 'mision'
    $vision->vision = $request->vision;
    $vision->save();

    return back()->with('success', 'Misión actualizada con éxito.');

    // Redirigir con mensaje de éxito
    
}
   

}
