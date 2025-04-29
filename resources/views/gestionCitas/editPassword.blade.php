

@php
    $perfil = session('usuario_perfil_id');
@endphp

@extends(
    $perfil === 1 ? 'layouts.perfil1' :
    ($perfil === 2 ? 'layouts.perfil2' :
    ($perfil === 3 ? 'layouts.perfil3' :'layouts.perfil4')))


@section('content')
    <h1>Actualizar contraseña</h1>

    @if(session('usuario_id'))
        <form action="{{ route('updatePassword') }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label for="password">Nueva contraseña:</label>
                <input type="password" name="password" id="password" required>

                @error('password')
                    <div>{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="password_confirmation">Confirmar contraseña:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>

            <button type="submit">Actualizar contraseña</button>
        </form>
    @else
        <p>No tienes permiso para acceder a esta página. Por favor, inicia sesión.</p>
    @endif
@endsection
