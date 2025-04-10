@extends('layouts.servinav')
@section('content')
    Sección actualización de servicios!<br>    
    En esta sección puedes editar y configurar los servicios prestados por nuestra entidad.<br>

    <div class="container">
    <h2>Actualización Servicios</h2>

    {{-- Select dinámico --}}
    <div class="form-group mb-3">
        <label for="servicio_select">Seleccionar servicio:</label>
        <select id="servicio_select" class="form-control">
            <option value="">-- Seleccione un servicio --</option>
            @foreach ($servicios as $servicio)
                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
            @endforeach
        </select>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

    {{-- Formulario de edición --}}
    <form id="edit_form" action="" method="POST" style="display:none;">
        @csrf
        @method('PUT')

        <!-- <input type="hidden" id="servicio_id"> -->
         <input type="text" name="id" id="servicio_id">

        <div class="form-group mb-3">
            <label for="nombre">Denominación del Servicio</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="precio">Teléfono</label>
            <input type="text" name="precio" id="precio" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>


{{-- Script --}}
<script>
    document.getElementById('servicio_select').addEventListener('change', function () {
        const servicioId = this.value;
        if (!servicioId) return;

        fetch(`/api/servicios/${servicioId}`)
            .then(response => response.json())
            .then(data => {
                // Rellenar los campos
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('precio').value = data.precio;
                document.getElementById('servicio_id').value = data.id;

                // Mostrar el formulario
                const form = document.getElementById('edit_form');
                form.style.display = 'block';

                // Cambiar la acción del formulario
                form.action = `/serviciosupdate/${data.id}`;
            });
    });
</script>
@endsection