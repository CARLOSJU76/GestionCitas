@extends('layouts.perfil1')

@section('content')
<div class="container">
    <h2>Actualiza tus Datos</h2>

    <form id="edit_form" action="{{ url('/clientes/' . $cliente->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">

        <div class="form-group mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $cliente->nombre }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="identificacion">Documento de Identidad</label>
            <input type="text" name="identificacion" id="identificacion" class="form-control" value="{{ $cliente->identificacion }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $cliente->email }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $cliente->telefono }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
