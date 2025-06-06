@extends('layouts.perfil4')
@section('content')

    Sección !<br>    
    En esta sección puedes agregar nuevos servicios!.<br>

    <div class="container">
        <h2>Agregar un Servicio</h2>

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
        <form action="{{ route('addservicios') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Servicio</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio del Servicio</label>
                <input type="text" name="precio" class="form-control" value="{{ old('precio') }}" required>
            <button type="submit" class="btn btn-primary">Guardar Servicio</button>
        </form>
    </div>
   
@endsection