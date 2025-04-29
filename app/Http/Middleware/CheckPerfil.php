<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class CheckPerfil
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $perfilRequerido
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, $perfilRequerido)
    {
        // Verificar si el usuario está autenticado
        if (!session()->has('usuario_id')) {
            // Redirigir al login si no está autenticado, usando la ruta correcta
            return redirect()->route('clientes.login.form')->with('error', 'Debe iniciar sesión.');
        }

        // Verificar si el perfil del usuario en sesión coincide con el perfil requerido
        if (session('usuario_perfil_id') !== (int) $perfilRequerido) {
            // Si no coincide, abortamos con un error 403 (Acceso denegado)
            return response('No tienes permiso para acceder.', 403);
        }

        return $next($request);
    }
}
