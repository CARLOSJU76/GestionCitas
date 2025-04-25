@extends('layouts.citasnav')
@section('content')
    Sección agendar Citas!<br>    
    En esta sección puedes agendar nuevas Citas para nuestros clientes.<br>

    <div class="container">
    <h2>Registrar nueva cita</h2>

    
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
            <select name="servicio_id" id="servicio_id" class="form-select" required>
                <option value="">Selecciona un servicio</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Horarios -->
        <div class="mb-3">
            <label for="horario_id" class="form-label">Estado:</label>
            <select name="horario_id" id="horario_id" class="form-select" required>
                <option value="">Selecciona un turno de servicio</option>
                <!-- Los horarios se actualizarán dinámicamente aquí -->
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

<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Event listener para el cambio de servicio
    $('#servicio_id').on('change', function() {
    var servicio_id = $(this).val();

    if (servicio_id) {
        $.ajax({
            url: '{{ route("getHorariosPorServicio") }}',
            method: 'GET',
            data: { servicio_id: servicio_id },
            success: function(response) {
                $('#horario_id').empty().append('<option value="">Selecciona un turno de servicio</option>');

                // Agrupamos horarios por fecha
                let horariosPorFecha = {};
                response.horarios.forEach(function(horario) {
                    let fecha = new Date(horario.fecha_hora).toISOString().split('T')[0];
                    if (!horariosPorFecha[fecha]) {
                        horariosPorFecha[fecha] = [];
                    }
                    horariosPorFecha[fecha].push(horario);
                });

                // Alternar colores por grupo de fechas
                let alternador = 0;
                for (let fecha in horariosPorFecha) {
                    let claseGrupo = (alternador % 2 === 0) ? 'dia-par' : 'dia-impar';
                    alternador++;

                    // Crear grupo de opciones
                    let grupo = $(`<optgroup label="${fecha}" class="${claseGrupo}"></optgroup>`);

                    horariosPorFecha[fecha].forEach(function(horario) {
                        grupo.append(`<option value="${horario.id}">${horario.fecha_hora}</option>`);
                    });

                    $('#horario_id').append(grupo);
                }
            }
        });
    } else {
        $('#horario_id').empty().append('<option value="">Selecciona un turno de servicio</option>');
    }
});

</script>

@endsection
