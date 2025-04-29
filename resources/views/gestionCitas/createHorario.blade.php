@extends('layouts.perfil3')
@section('title', 'Agregar Horarios por Semana')
@section('content')
    Sección registro de Horarios!<br>    
    En esta sección puedes agregar los Horarios planeados para la Atención al Cliente.<br>

  

<div class="card shadow-sm p-4 mx-auto" style="max-width: 600px;">
    <h4 class="mb-4">Agregar Horario</h4>

    <form action="{{ route('horarios.storeMultiple') }}" method="POST" class="d-flex flex-column gap-3">
        @csrf

        {{-- Servicio --}}
        <div>
            <label for="servicio_id" class="form-label">Servicio</label>
            <select name="servicio_id" id="servicio_id" class="form-select" required>
                <option value="">-- Selecciona un servicio --</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                @endforeach
            </select>
        </div>

        {{-- Rango de fechas --}}
        <div>
            <label class="form-label">Fecha de Inicio</label>
            <input type="date" name="fecha_inicio" class="form-control" required>
        </div>

        <div>
            <label class="form-label">Fecha de Fin</label>
            <input type="date" name="fecha_fin" class="form-control" required>
        </div>

        {{-- Días de la semana --}}
        <div>
            <label class="form-label">Días de la semana</label>
            <div class="d-flex flex-wrap gap-2">
                @foreach(['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'] as $i => $dia)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dias[]" value="{{ $i }}" id="dia{{ $i }}">
                        <label class="form-check-label" for="dia{{ $i }}">{{ $dia }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Horarios --}}
        <div>
            <label class="form-label">Horarios</label>
            <div id="horarios-container">
                <input type="time" name="horas[]" class="form-control mb-2" required>
            </div>
            <button type="button" id="add-horario" class="btn btn-outline-primary btn-sm mt-2">
                <i class="bi bi-plus-circle"></i> Agregar otro horario
            </button>
        </div>

        {{-- Botón --}}
        <div class="text-end">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Guardar horarios
            </button>
        </div>
    </form>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('horarios-container');
        const addBtn = document.getElementById('add-horario');

        addBtn.addEventListener('click', function () {
            const input = document.createElement('input');
            input.type = 'time';
            input.name = 'horas[]';
            input.className = 'form-control mb-2';
            container.appendChild(input);
        });
    });
</script>
