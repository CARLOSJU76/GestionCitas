@extends('layouts.perfil1')

@section('title', 'Registrar Mi Vehículo')

@section('content')
<div class="container">
    <h2>Registrar Nuevo Vehículo</h2>

  

    {{-- Mensajes de error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario para registrar vehículo --}}
    <form action="{{ route('storeMyCar') }}" method="POST" class="mb-4">
        @csrf

        <div class="mb-3">
            <label for="placa" class="form-label">Placa del Vehículo</label>
            <input type="text" class="form-control" id="placa" name="placa" required maxlength="10">
        </div>

        <button type="submit" class="btn btn-primary">Registrar Vehículo</button>
    </form>

    {{-- Lista de vehículos --}}
    <h3>Mis Vehículos Registrados</h3>

    @if($vehiculos->isEmpty())
        <p class="text-muted">No tienes vehículos registrados aún.</p>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Placa</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehiculos as $index => $vehiculo)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $vehiculo->placa }}</td>
                            <td>{{ $vehiculo->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <form action="{{ route('destroyMyCar', $vehiculo->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este vehículo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash3"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
