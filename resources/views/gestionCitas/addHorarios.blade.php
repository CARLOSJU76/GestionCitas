@extends('layouts.horariosnav')
@section('content')
    Sección Clientes!<br>    
    En esta sección puedes agregar los Horarios planeados para la Atención al Cliente.<br>

    <div class="container">
        <h2>Insertar Cliente</h2>

        {{-- Mensajes de error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <form action="{{ route('addHorarios') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="servicio_id" class="form-label">Servicio:</label>
                <select name="servicio_id" class="form-select" required>
                    <option value="">Selecciona un servicio</option>
                    @foreach($servicios as $servicio)
                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha_hora" class="form-label">Fecha y hora:</label>
                <input type="datetime-local" name="fecha_hora" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Servicio</button>
        </form>
    </div>


  </tbody>
</table>
    
@endsection