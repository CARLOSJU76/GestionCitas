@extends('layouts.citasnav')
@section('content')
    Sección Actualiar Citas!<br>    
    En esta sección puedes actualizar y edtar las citas agendas por nuestros clientes.<br>

    <div class="container">
    <h2>Actulización de Citas</h2>

    {{-- Select dinámico --}}
    <div class="form-group mb-3">
        <label for="cita_select">Seleccionar cliente:</label>
        <select id="cita_select" class="form-control">
            <option value="">-- Seleccione una Cita programada --</option>
            @foreach ($citas as $cita)
                <option value="{{ $cita->id }}">{{ $cita->cliente_nombre }}</option>
            @endforeach
        </select>
    </div>

    {{-- Formulario de edición --}}
    <form id="edit_form" action="" method="POST" style="display:none;">
    @csrf
    @method('PUT')

    <input type="hidden" id="cita_id" name="cita_id">

    {{-- Select Cliente --}}
    <div class="form-group mb-3">
        <label for="cliente_id">Cliente</label>
        <select name="cliente_id" id="cliente_id" class="form-control" required>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
            @endforeach
        </select>
    </div>

    {{-- Select Servicio --}}
    <div class="form-group mb-3">
        <label for="servicio_id">Servicio</label>
        <select name="servicio_id" id="servicio_id" class="form-control" required>
            @foreach ($servicios as $servicio)
                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
            @endforeach
        </select>
    </div>

    {{-- Select Estado --}}
    <div class="form-group mb-3">
        <label for="estado_id">Estado</label>
        <select name="estado_id" id="estado_id" class="form-control" required>
            @foreach ($estados as $estado)
                <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>

</div>


{{-- Script --}}
<script>
    document.getElementById('cita_select').addEventListener('change', function () {
        const clienteId = this.value;
        if (!clienteId) return;

        fetch(`/api/clientes/${clienteId}`)
            .then(response => response.json())
            .then(data => {
                // Rellenar los campos
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('telefono').value = data.telefono;
                document.getElementById('cliente_id').value = data.id;

                // Mostrar el formulario
                const form = document.getElementById('edit_form');
                form.style.display = 'block';

                // Cambiar la acción del formulario
                form.action = `/clientes/${data.id}`;
            });
    });
</script>
@endsection