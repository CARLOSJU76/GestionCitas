@extends('layouts.quienesSomos')

@section('content')
    <div class="container-mision">
        <h2 class="titulo-mision">Nuestra Misión</h2>

        @foreach ($mision as $misionItem)
            <p class="texto-mision">{{ $misionItem->mision }}</p>
        @endforeach
    </div>
@endsection

