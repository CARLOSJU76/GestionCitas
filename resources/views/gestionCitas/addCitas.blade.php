@extends('layouts.citasnav')
@section('content')
    Sección agendar Citas!<br>    
    En esta sección puedes agendar nuevas Citas para nuestros clientes.<br>

    <div class="container">
    <h2>Registrar nueva cita</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('addCitas') }}" method="POST">
        @csrf

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

        <!-- Servicio -->
        <div class="mb-3">
            <label for="servicio_id" class="form-label">Servicio:</label>
            <select name="servicio_id" class="form-select" required>
                <option value="">Selecciona un servicio</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                @endforeach
            </select>
        </div>

       
        <!-- Fecha y Hora -->
        <div class="mb-3">
            <label for="horario_id" class="form-label">Estado:</label>
            <select name="horario_id" class="form-select" required>
                <option value="">Selecciona  un turno de servicio</option>
                @foreach($horarios as $horario)
                    <option value="{{ $horario->id }}">{{ $horario->fecha_hora }}</option>
                @endforeach
            </select>
        </div>

         <!-- Estado -->
         <div class="mb-3">
            <label for="estado_id" class="form-label">Estado:</label>
            <select name="estado_id" class="form-select" required>
                <option value="">Selecciona un estado</option>
                @foreach($estados as $estado)
                    <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cita</button>
    </form>
</div>

  
@endsection