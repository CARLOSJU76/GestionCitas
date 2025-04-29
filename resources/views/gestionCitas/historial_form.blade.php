@extends('layouts.perfil2Citas')
@section('content')
    <div class="container">
        <h1>Historial de Citas</h1>

        <!-- Formulario de selección de cliente -->
        <form action="{{ route('historialCitas') }}" method="GET">
            <div class="form-group">
                <label for="cliente_id">Seleccionar Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->identificacion }}" 
                                @if(request()->cliente_id == $cliente->identificacion) selected @endif>
                            {{ $cliente->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Ver Historial</button>
        </form>

        <br>

        <!-- Tabla de historial de citas -->
        @if(request()->has('cliente_id') && $historialCitas->isEmpty())
            <p>No hay citas registradas para este cliente.</p>
        @elseif(request()->has('cliente_id'))
            <h3>Historial de Citas - Cliente: {{ request()->cliente_id }}</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cita ID</th>
                        <th>Cliente Nombre</th>
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
                            <td>{{ $historial->cliente_nombre }}</td>
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