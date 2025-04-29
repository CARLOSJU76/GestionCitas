
@extends('layouts.perfil1')

@section('content')
    <div class="container">
        <h1>Mi Historial de Citas</h1>

        @if($cliente)
            <h3>Cliente: {{ $cliente->nombre }}</h3>
        @endif

        @if($historialCitas->isEmpty())
            <p>No tienes citas registradas.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cita ID</th>
                        <th>Servicio</th>
                        <th>Estado</th>
                        <th>Fecha y Hora</th>
                        <th>Vehículo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historialCitas as $historial)
                        <tr>
                            <td>{{ $historial->id }}</td>
                            <td>{{ $historial->cita_id }}</td>
                            <td>{{ $historial->servicio_nombre }}</td>
                            <td>{{ $historial->estado_nombre }}</td>
                            <td>{{ $historial->fecha_hora }}</td>
                            <td>{{ $historial->vehiculo }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

    @endsection