@extends('layouts.perfil2Citas')

@section('content')
<div class="container">
    <h2>Editar Cita</h2>
    <p>Selecciona una cita agendada para actualizar su información:</p>

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

    {{-- Formulario de edición (inicialmente oculto) --}}
    <form id="edit_form" method="POST" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" id="cita_id" name="cita_id">

        {{-- Cliente --}}
        <div class="form-group mb-3">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-control" required>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        {{-- Servicio --}}
        <div class="form-group mb-3">
            <label for="servicio_id">Servicio</label>
            <select name="servicio_id" id="servicio_id" class="form-control" required>
                @foreach ($servicios as $servicio)
                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="vehiculo_id" class="form-label">Vehículo:</label>
            <select name="vehiculo_id" id="vehiculo_id" class="form-select" required>
                <option value="">Selecciona un Vehículo </option>
                
            </select>
        </div>

        {{-- Horario --}}
        <div class="form-group mb-3">
            <label for="horario_id">Horario</label>
            <select name="horario_id" id="horario_id" class="form-control" required>
                <!-- Se llena dinámicamente -->
            </select>
        </div>

        {{-- Estado --}}
        <div class="form-group mb-3">
            <label for="estado_id">Estado</label>
            <select name="estado_id" id="estado_id" class="form-control" required>
                @foreach ($estados as $estado)
                    <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Cita</button>
    </form>
</div>

{{-- JS Dinámico --}}
<script>
document.getElementById('cita_select').addEventListener('change', function () {
    const citaId = this.value;
    if (!citaId) return;

    fetch(`/api/citas/${citaId}`)
        .then(res => res.json())
        .then(data => {
            const form = document.getElementById('edit_form');
            form.action = `/citasupdate/${data.id}`; // Actualiza ruta de envío
            form.style.display = 'block';

            document.getElementById('cita_id').value = data.id;
            document.getElementById('cliente_id').value = data.cliente_id;
            document.getElementById('servicio_id').value = data.servicio_id;
            document.getElementById('estado_id').value = data.estado_id;

            cargarHorarios(data.servicio_id, data.horario_id, data.fecha_hora);
            cargarVehiculos(data.cliente_id); // Cargar vehículos del cliente

            // Establecer el evento onchange para el servicio
            document.getElementById('servicio_id').onchange = function () {
                const servicioId = this.value;
                cargarHorarios(servicioId, null, null);  // Se recargan los horarios cuando cambie el servicio
            };
        })
        .catch(err => {
            console.error(err);
            alert("Error al cargar los datos de la cita.");
        });
});

function cargarVehiculos(clienteId) {
    const vehiculoSelect = document.getElementById('vehiculo_id');
    vehiculoSelect.innerHTML = '<option>Cargando vehículos...</option>';

    fetch(`/api/vehiculos?cliente_id=${clienteId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        const vehiculos = data.vehiculos || [];
        vehiculoSelect.innerHTML = '';

        vehiculos.forEach(v => {
            const option = document.createElement('option');
            option.value = v.id;
            option.textContent = v.placa;
            vehiculoSelect.appendChild(option);
        });
    })
    .catch(err => {
        console.error("Error cargando vehículos:", err);
    });
}

function cargarHorarios(servicioId, horarioActualId = null, horarioTexto=null) {
    const horarioSelect = document.getElementById('horario_id');
    horarioSelect.innerHTML = '<option>Cargando horarios...</option>';

    fetch(`/api/horarios?servicio_id=${servicioId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        const horarios = data.horarios || [];
        horarioSelect.innerHTML = '';

        let agrupados = {};

        if (horarioActualId && horarioTexto) {
            const actual = document.createElement('option');
            actual.value = horarioActualId;
            actual.textContent = new Date(horarioTexto).toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            }) + ' (Actual)';
            actual.selected = true;
            horarioSelect.appendChild(actual);
        }

        horarios.forEach(h => {
    if (h.disponible && new Date(h.fecha_hora) >= new Date()) {
        let fecha = new Date(h.fecha_hora).toISOString().split('T')[0];
         // Solo fecha: "YYYY-MM-DD"
        if (!agrupados[fecha]) agrupados[fecha] = [];
        agrupados[fecha].push(h);
    }
});

Object.entries(agrupados).forEach(([fecha, hs], index) => {
    const grupo = document.createElement('optgroup');
    grupo.label = fecha;
    grupo.className = index % 2 === 0 ? 'dia-par' : 'dia-impar'; // Alternar color (usa CSS)

    hs.forEach(h => {
        const option = document.createElement('option');
        option.value = h.id;

        // Mostrar solo la hora (HH:mm)
        const hora = new Date(h.fecha_hora).toLocaleTimeString('es-ES', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });

        option.textContent = hora;
        grupo.appendChild(option);
    });

    horarioSelect.appendChild(grupo);
});


        // ✅ Seleccionar automáticamente el horario actual si está presente
        if (horarioActualId) {
            horarioSelect.value = horarioActualId;
        }
    })
    .catch(err => {
        console.error("Error cargando horarios:", err);
    });
}

</script>

@endsection
