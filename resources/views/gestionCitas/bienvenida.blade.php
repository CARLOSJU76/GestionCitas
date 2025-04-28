@extends('layouts.nav')

@section('content')
    <h1>Bienvenido, {{ session('usuario_nombre') }}!</h1>
    <p>Tu email es: {{ session('usuario_email') }}</p>
    <p>Tu perfil es: {{ session('usuario_perfil') }}</p>
@endsection

