@extends('layouts.perfil4')
@section('content')

    <div class="container">
        <h2 class="text-center">Actualizar Misión</h2>

        <form action="{{ route('mision.update') }}" method="POST" class="form-update-mission">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="mision">Misión:</label>
                <textarea name="mision" id="mision" required class="form-control">{{ old('mision', $mision->mision) }}</textarea>
                
                @error('mision')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-lg">Guardar cambios</button>
            </div>
        </form>
    </div>

@endsection

@section('styles')
    <style>
        .form-update-mission {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        #mision {
            width: 100%;
            height: 200px;
            padding: 10px;
            font-size: 1.1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-size: 1.2em;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        h2 {
            font-family: 'Arial', sans-serif;
            color: #333;
            font-size: 2em;
        }
    </style>
@endsection
