@extends('layouts.citasnav')
@section('content')
    Sección Citas!<br>    
    En esta sección puedes consultar las citas agendas a nuestros clientes.<br>
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Servicio</th>
            <th>Estado</th>
            <th>Fecha y Hora</th>
        </tr>
    </thead>
    <tbody>
        @foreach($citas as $cita)
            <tr>
                <td>{{ $cita->cliente_nombre }}</td>
                <td>{{ $cita->servicio_nombre }}</td>
                <td>{{ $cita->estado }}</td>
                <td>{{ $cita->fecha_hora }}</td>
                <td>
                    <form action = "{{ route('deleteCita', $cita->id) }}" method='post' onsubmit="return confirm('Seguro que quieres eliminar los datos del Cliente?;')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach

    </tbody>

</table>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@endsection