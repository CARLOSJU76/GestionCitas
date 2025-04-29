@extends('layouts.perfil3')
@section('title', 'Consultar Horarios')
@section('content')
    <p>Sección Clientes!<br>    
    En esta sección puedes consultar los Horarios de Atención.</p>

<div class="container py-4">
    <h4>Horarios de Atención</h4>

    {{-- Filtro por servicio --}}
    <form method="GET" action="{{ route('horarios.index') }}" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <select name="servicio_id" class="form-select">
                    <option value="">-- Todos los servicios --</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->id }}" {{ $servicio_id == $servicio->id ? 'selected' : '' }}>
                            {{ $servicio->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    {{-- Mostrar horarios si se ha seleccionado un servicio --}}
    @if($servicio_id)
        @forelse($horarios as $fecha => $horariosDelDia)
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <strong>{{ \Carbon\Carbon::parse($fecha)->translatedFormat('l, d F Y') }}</strong>
                </div>
                <div class="card-body">
                    <ul class="list-inline mb-0">
                        @foreach($horariosDelDia as $horario)
                            <li class="list-inline-item me-4">
                                <span class="me-2">{{ \Carbon\Carbon::parse($horario->fecha_hora)->format('H:i') }}</span>

                                {{-- Editar ícono --}}
                                <a href="{{ route('horarios.edit', $horario->id) }}" class="text-primary me-1" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                {{-- Eliminar ícono --}}
                                <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Eliminar este horario?')" class="btn btn-link p-0 text-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @empty
            <div class="alert alert-info">Este servicio no tiene horarios disponibles.</div>
        @endforelse
    @else
        <div class="alert alert-secondary">Selecciona un servicio para ver sus horarios.</div>
    @endif
</div>
@endsection
