@extends('layouts.quienesSomos')

@section('content')
    <div class="container-mision">
        <h2 class="titulo-mision">Nuestra Visión</h2>

        @foreach ($vision as $visionItem)
            <p class="texto-mision">{{ $visionItem->vision }}</p>
        @endforeach
    </div>
@endsection

