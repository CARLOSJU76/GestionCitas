<?php

namespace App\Http\Controllers;
use App\Models\Clientes;
use App\Models\Perfil; // Asegúrate de importar el modelo de la tabla 'perfiles' si lo usas para validación de clave foránea
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Servicios;
use App\Models\Estados; // Asegúrate de importar el modelo de la tabla 'vehiculos' si lo usas para validación de clave foránea
use App\Models\Vehiculo; // Asegúrate de importar el modelo de la tabla 'vehiculos' si lo usas para validación de clave foránea
class ClienteController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'identificacion' => 'required|string|max:20|unique:clientes',  // Validar identificación única
            'email' => 'required|email|unique:clientes',  // Validar email único
            'password' => 'required|string|min:8|confirmed', // Validar contraseña (mínimo 8 caracteres y confirmación)
        ]);

        // Crear el cliente
        $cliente = Clientes::create([
            'nombre' => $validated['nombre'],
            'telefono' => $validated['telefono'],
            'identificacion' => $validated['identificacion'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Encriptar la contraseña
        ]);

        // Devolver respuesta (puede ser un redirect o JSON)
        return redirect()->route('agregar')->with('success', 'Cliente incluido en BD exitosamente.');
    }
    
    public function viewCliente()
    {
        // Primero ejecuta la consulta
        $clientes = Clientes::with('perfil')->get();
    
        // Luego oculta el campo password
        $clientes->makeHidden(['password']);
    
        return view('gestioncitas.clientes', compact('clientes'));
    }
    


    public function deleteCliente($id)
    {
        $cliente = Clientes::find($id);
        if (!$cliente) {
            return redirect()->route('clientes', ['id' => $id])->with('error', 'No se encontraron datos del cliente.');
        }
        $cliente->delete();
        return redirect()->route('clientes', ['id' => $id])
                         ->with('success', 'Datos del Cliente han sido excluidos de la Base de Datos.');
    }

    public function update(Request $request, $id)
    {
        // Validar los datos que vienen en la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'identificacion' => 'required|string|max:20|unique:clientes,identificacion,' . $id, // Excluir el cliente actual de la validación
            'email' => 'required|email|unique:clientes,email,' . $id, // Excluir el cliente actual de la validación
            // 'perfil_id' => 'required|exists:perfiles,id', // Validar que perfil_id exista en la tabla perfiles
        ]);

        // Buscar el cliente
        $clientes = Clientes::findOrFail($id);

        // Actualizar los campos
        $clientes->nombre = $request->input('nombre');
        $clientes->telefono = $request->input('telefono');
        $clientes->identificacion = $request->input('identificacion');
        $clientes->email = $request->input('email');
        // $clientes->perfil_id = $request->input('perfil_id');

        // Guardar los cambios
        $clientes->save();
        
        return back()->with('success', 'Información actualizada en BD exitosamente.');
    }

    public function getCliente($id)
    {
        $cliente = Clientes::findOrFail($id);
        return response()->json($cliente);
    }

    public function ajaxEditView()
    {
        $clientes = Clientes::all();
        return view('gestionCitas.updateClientes', compact('clientes'));
    }
    public function editPerfilCliente()
{
    $clienteId = session('usuario_id');  // Obtener el ID guardado en la sesión
    $cliente = Clientes::find($clienteId);

    return view('gestioncitas.editarcliente', compact('cliente'));
}
public function showFormularioCita()
{
    $usuario_id = session('usuario_id'); // <- Tu ID guardado al iniciar sesión

    $servicios = Servicios::all();
    
    $vehiculos = Vehiculo::where('cliente_id', $usuario_id)->get(); // <- Los vehículos del cliente

    return view('gestioncitas.crearcita', compact('servicios', 'vehiculos', 'usuario_id'));
}
public function editPerfil()
{
    $clientes = Clientes::all();  // Obtener todos los clientes
    $perfiles = Perfil::all();   // Obtener todos los perfiles disponibles

    return view('gestionCitas.editPerfil', compact('clientes', 'perfiles'));
}

public function updatePerfil(Request $request, $id)
{
    // Validar solo el perfil
    $request->validate([
        'perfil_id' => 'required|exists:perfils,id',
    ]);

    // Buscar cliente
    $cliente = Clientes::findOrFail($id);

    // Actualizar solo el perfil
    $cliente->perfil_id = $request->input('perfil_id');
    $cliente->save();

    return back()->with('success', 'Perfil actualizado exitosamente.');
}
public function editPassword()
{

    return view('gestionCitas.editPassword');
}
public function updatePassword(Request $request)
    {
        // Obtener el ID del cliente desde la sesión
        $clienteId = session('usuario_id');

        // Verificar si el ID del cliente existe en la sesión
        if (!$clienteId) {
            return redirect()->route('login')->with('error', 'No estás autenticado');
        }

        // Validación del campo 'password'
        $request->validate([
            'password' => 'required|string|min:8|confirmed', // Confirmación de la contraseña
        ]);

        // Buscar al cliente en la base de datos por su ID
        $cliente = Clientes::findOrFail($clienteId);

        // Actualizar la contraseña del cliente
        $cliente->password = Hash::make($request->password); // Cifrado de la contraseña

        // Guardar los cambios en la base de datos
        $cliente->save();
        return back()->with('success', 'Contraseña actualizada exitosamente.');

    }

}