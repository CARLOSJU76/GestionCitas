@extends('layouts.perfil3')

@section('content')
<div class="container">
    <h2>Actualizar Estado de Cita</h2>
    <p>Selecciona una cita y actualiza su estado:</p>

    {{-- Select para elegir cita --}}
    <div class="form-group mb-3">
        <label for="cita_select">Citas programadas:</label>
        <select id="cita_select" class="form-control">
            <option value="">-- Selecciona una cita --</option>
            @foreach ($citas as $cita)
                <option value="{{ $cita->id }}">
                    {{ $cita->cliente->nombre ?? 'Cliente eliminado' }} - 
                    {{ \Carbon\Carbon::parse($cita->horario->fecha_hora)->format('d/m/Y H:i') }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Formulario de cambio de estado --}}
    <form id="edit_form" method="POST" style="display: none;">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="estado_id">Estado de la Cita</label>
            <select name="estado_id" id="estado_id" class="form-control" required>
                @foreach ($estados as $estado)
                    <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Estado</button>
    </form>
</div>

{{-- JS para mostrar el formulario --}}
<script>
document.getElementById('cita_select').addEventListener('change', function () {
    const citaId = this.value;
    const form = document.getElementById('edit_form');

    if (!citaId) {
        form.style.display = 'none';
        return;
    }

    form.action = `/citasestado/${citaId}`; // Ajusta la URL de acción al seleccionar cita
    form.style.display = 'block';
});
</script>

@endsection
