@extends('layouts.clientenav')
@section('content')
    Sección actualización de Clientes<br>    
    En esta sección puedes actualizar los datos de los Clientes y/o pacientes.<br>

    <div class="container">
    <h2>Actulización Datos de Clientes</h2>

    {{-- Select dinámico --}}
    <div class="form-group mb-3">
        <label for="cliente_select">Seleccionar cliente:</label>
        <select id="cliente_select" class="form-control">
            <option value="">-- Seleccione un cliente --</option>
            @foreach ($clientes as $c)
                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>

    {{-- Formulario de edición --}}
    <form id="edit_form" action="" method="POST" style="display:none;">
        @csrf
        @method('PUT')

        <input type="hidden" id="cliente_id">

        <div class="form-group mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>


{{-- Script --}}
<script>
    document.getElementById('cliente_select').addEventListener('change', function () {
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