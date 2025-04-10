@extends('layouts.clientenav')
@section('content')
    Sección inscripción de clientes!<br>    
    En esta sección puedes inlcuir nuevos  Clientes y/o pacientes.<br>

    <div class="container">
        <h2>Insertar Cliente</h2>

        {{-- Mensajes de error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <form action="{{ route('agregar') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cliente</button>
        </form>
    </div>
   

@endsection




   