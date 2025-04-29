@extends('layouts.perfil2Cliente') <!-- O el layout que uses -->
@section('content')

<div class="container">
    <h2>Registrar Vehículo</h2>

    <form action="{{ route('vehiculos.store') }}" method="POST">
        @csrf

        <!-- Placa -->
        <div class="mb-3">
            <label for="placa" class="form-label">Placa:</label>
            <input type="text" name="placa" class="form-control" required>
        </div>

        <!-- Cliente -->
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente:</label>
            <select name="cliente_id" class="form-select" required>
                <option value="">Selecciona un cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Vehículo</button>
    </form>
</div>

@endsection
