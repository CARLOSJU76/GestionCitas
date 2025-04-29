@extends('layouts.perfil4')

@section('content')
    <div class="container">
        <h2>Actualizar Perfil del Cliente</h2>

        {{-- Formulario de selección de cliente y actualización de perfil --}}
        <form id="update_perfil_form" action="" method="POST">
            @csrf
            @method('PUT')

            {{-- Select para elegir cliente --}}
            <div class="form-group mb-3">
                <label for="cliente_select">Seleccionar Cliente:</label>
                <select name="cliente_id" id="cliente_select" class="form-control" required>
                    <option value="">-- Seleccione un cliente --</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" 
                            {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }} 
                            ({{ $cliente->perfil ? $cliente->perfil->nombre : 'Sin perfil' }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Select para elegir perfil --}}
            <div class="form-group mb-3" id="perfil_div" style="display: none;">
                <label for="perfil_id">Seleccionar Perfil:</label>
                <select name="perfil_id" id="perfil_id" class="form-control" required>
                    @foreach ($perfiles as $perfil)
                        <option value="{{ $perfil->id }}">{{ $perfil->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary" id="submit_button" style="display: none;">Actualizar Perfil</button>
        </form>
    </div>

    {{-- Script para mostrar el select de perfil cuando se selecciona un cliente --}}
    <script>
        document.getElementById('cliente_select').addEventListener('change', function () {
            const clienteId = this.value;
            const perfilDiv = document.getElementById('perfil_div');
            const submitButton = document.getElementById('submit_button');

            // Si se selecciona un cliente, mostrar el select de perfil
            if (clienteId) {
                perfilDiv.style.display = 'block';
                submitButton.style.display = 'inline-block';

                // Cambiar la acción del formulario con el id del cliente seleccionado
                const form = document.getElementById('update_perfil_form');
                form.action = '/clientes/' + clienteId + '/perfil';  // Ruta para actualizar solo el perfil
            } else {
                perfilDiv.style.display = 'none';
                submitButton.style.display = 'none';
            }
        });
    </script>
@endsection


