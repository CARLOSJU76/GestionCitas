@extends('layouts.citasnav')
@section('content')
    Sección Actualiar Citas!<br>    
    En esta sección puedes actualizar y edtar las citas agendas por nuestros clientes.<br>

    <div class="container">
    <h2>Actualización de Citas</h2>

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
    <!-- fecha y hora -->
        <div class="form-group mb-3">
            <label for="fecha_hora">Fecha y hora</label>
            <input type="datetime-local" name="fecha_hora"  id="fecha_hora" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>

</div>


{{-- Script --}}
<script>
    document.getElementById('cita_select').addEventListener('change', function () {
        const citaId = this.value;
        if (!citaId) return;

        fetch(`/api/citas/${citaId}`)
            .then(response => response.json())
            .then(data => {
                // Establecer los valores actuales en los selects
                document.getElementById('cita_id').value = data.id;

                document.getElementById('cliente_id').value = data.cliente_id;
                document.getElementById('servicio_id').value = data.servicio_id;
                document.getElementById('estado_id').value = data.estado_id;
                document.getElementById('fecha_hora').value = data.fecha_hora;

                // Mostrar el formulario
                const form = document.getElementById('edit_form');
                form.style.display = 'block';

                // Establecer la acción del formulario con la ruta correcta
                form.action = `/citasupdate/${data.id}`;
            })
            .catch(error => {
                console.error('Error al obtener datos de la cita:', error);
                alert('Ocurrió un error al cargar la información de la cita.');
            });
    });
</script>

@endsection