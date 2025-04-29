@extends('layouts.perfil3')
@section('content')
    Edición de Horarios!<br>    
    En esta sección puedes editar los Horarios planeados para la Atención al Cliente.<br>

   
    <h2>Editar Horario</h2>

    <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="fecha_hora">Fecha y hora:</label>
            <input type="datetime-local" name="fecha_hora" id="fecha_hora"
                   value="{{ \Carbon\Carbon::parse($horario->fecha_hora)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div>
            <label for="servicio_id">Servicio:</label>
            <select name="servicio_id" id="servicio_id" required>
                @foreach ($servicios as $servicio)
                    <option value="{{ $servicio->id }}" {{ $servicio->id == $horario->servicio_id ? 'selected' : '' }}>
                        {{ $servicio->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit">Actualizar</button>
    </form>
@endsection

    
