@extends('layouts.perfil4')

@section('content')
<h1>Bienvenido, {{ session('usuario_nombre') }}!</h1>
    <h2>{{ session('usuario_email') }}</h2>
    <h3>Perfil: {{ session('usuario_perfil') }}</h3>
@endsection

