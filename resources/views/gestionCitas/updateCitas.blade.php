@extends('layouts.citasnav')
@section('content')
    Sección Actualizar Citas!<br>    
    En esta sección puedes actualizar y editar las citas agendadas por nuestros clientes.<br>

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

     <!-- Horarios -->
     <div class="mb-3">
        <label for="horario_id" class="form-label">Horario:</label>
        <select name="horario_id" id="horario_id" class="form-select" required>
            <!-- Se llenará dinámicamente vía JavaScript -->
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
    const citaId = this.value;
    if (!citaId) return;

    fetch(`/api/citas/${citaId}`)
    
        .then(response => response.json())
        .then(data => {
            // Setear valores actuales
            document.getElementById('cita_id').value = data.id;
            document.getElementById('cliente_id').value = data.cliente_id;
            document.getElementById('servicio_id').value = data.servicio_id;
            document.getElementById('estado_id').value = data.estado_id;

            const form = document.getElementById('edit_form');
            form.action = `/citasupdate/${data.id}`;
            form.style.display = 'block';

            // Cargar horarios para el servicio actual
            cargarHorarios(data.servicio_id, data.horario_id, data.fecha_hora);

            // Evento cuando cambia el servicio
            document.getElementById('servicio_id').addEventListener('change', function () {
                const nuevoServicioId = this.value;
                cargarHorarios(nuevoServicioId, data.horario_id, data.fecha_hora);
            });
        })
        .catch(error => {
            console.error('Error al obtener datos de la cita:', error);
            alert('Ocurrió un error al cargar la información de la cita.');
        });
});

// Función reutilizable para cargar horarios agrupados por fecha
function cargarHorarios(servicioId, horarioActualId, horarioActualTexto) {
    const horarioSelect = document.getElementById('horario_id');
    horarioSelect.innerHTML = ''; // Limpiar las opciones

    // Agregar opción actual
    const opcionActual = document.createElement('option');
    opcionActual.value = horarioActualId;
    opcionActual.selected = true;
    opcionActual.textContent = horarioActualTexto;
    horarioSelect.appendChild(opcionActual);

    // Traer horarios disponibles por servicio
    fetch(`{{ route('getHorariosPorServicio') }}?servicio_id=${servicioId}`)
        .then(resp => resp.json())
        .then(horarios => {
            // Agrupar los horarios por fecha
            let horariosPorFecha = {};
            horarios.forEach(horario => {
                if (horario.id !== horarioActualId && horario.disponible && new Date(horario.fecha_hora) >= new Date()) {
                    const fecha = new Date(horario.fecha_hora).toISOString().split('T')[0];
                    if (!horariosPorFecha[fecha]) {
                        horariosPorFecha[fecha] = [];
                    }
                    horariosPorFecha[fecha].push(horario);
                }
            });

            // Alternar entre los grupos y agregar las opciones al select
            let alternador = 0;
            for (let fecha in horariosPorFecha) {
                const claseGrupo = alternador % 2 === 0 ? 'dia-par' : 'dia-impar';
                alternador++;
                const grupo = document.createElement('optgroup');
                grupo.label = fecha;
                grupo.className = claseGrupo;

                horariosPorFecha[fecha].forEach(horario => {
                    const option = document.createElement('option');
                    option.value = horario.id;
                    option.textContent = horario.fecha_hora;
                    grupo.appendChild(option);
                });

                horarioSelect.appendChild(grupo);
            }
        })
        .catch(err => {
            console.error('Error al cargar horarios:', err);
        });
}
</script>

@endsection
