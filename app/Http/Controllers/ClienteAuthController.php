<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clientes;  // Importamos el modelo Clientes
use Illuminate\Support\Facades\Hash;

class ClienteAuthController extends Controller
{
    // Muestra el formulario de login
    public function showLoginForm()
    {
        return view('gestioncitas.login');
    }

    // Realiza la autenticación del cliente
    public function login(Request $request)
{
    // Validar los datos del formulario de login
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Buscar el usuario en la base de datos
    $cliente = Clientes::where('email', $request->email)->first();

    // Verificar si el usuario existe y la contraseña es correcta
    if ($cliente && password_verify($request->password, $cliente->password)) {
        // Obtener el nombre del perfil asociado al cliente
        $perfilNombre = $cliente->perfil ? $cliente->perfil->nombre : 'Sin perfil asignado';

        // Si la autenticación es exitosa, guardar los datos en la sesión
        session([
            'usuario_id' => $cliente->id,
            'usuario_nombre' => $cliente->nombre,
            'usuario_email' => $cliente->email,
            'usuario_perfil' => $perfilNombre, // Guardar el nombre del perfil
        ]);

        // Redirigir a la página de bienvenida
        return redirect()->route('misDatos')->with('success', 'Bienvenido, ' . $cliente->nombre);
    }

    // Si el login falla, redirigir con un mensaje de error
    return back()->withErrors(['email' => 'Credenciales incorrectas'])->withInput();
}
public function logout(Request $request)
    {
        // Eliminar los datos de sesión
        $request->session()->flush();  // O puedes usar session()->forget('usuario_id') para eliminar solo ciertos valores

        // Si estás usando autenticación de Laravel, también puedes usar Auth::logout():
        Auth::logout();

        // Redirigir al usuario al formulario de login o a donde desees
        return redirect()->route('clientes.login.form')->with('success', 'Has cerrado sesión exitosamente');
    }

    
    

}
