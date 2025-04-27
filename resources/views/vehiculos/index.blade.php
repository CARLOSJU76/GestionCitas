@extends('layouts.clientenav') <!-- O el layout que uses -->
@section('content')

<div class="container">
    <h2>Listado de Vehículos</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Placa</th>
                <th>Cliente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehiculos as $vehiculo)
                <tr>
                    <td>{{ $vehiculo->id }}</td>
                    <td>{{ $vehiculo->placa }}</td>
                    <td>{{ optional($vehiculo->cliente)->nombre ?? 'Cliente no asignado' }}</td>
                    <td>
                        <!-- Botón para eliminar -->
                        <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este vehículo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
