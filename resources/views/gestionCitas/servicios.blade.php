@extends('layouts.perfil4')
@section('content')
    Sección Servicios!<br>    
    En esta sección puedes consultar los Servicios que presta nuestra entidad.<br>
    <h3>Consultar Servicios</h3>
    <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Código</th>
      <th scope="col">Nombre del Servicio</th>
      <th scope="col">Precio</th>
    </tr>
  </thead>
  <tbody>
    @foreach($servicios as $servicio)
    
    <tr>
      <th scope="row">{{$servicio->id}}</th>
      <td>{{$servicio->nombre}}</td>
      <td>{{$servicio->precio}}</td>
      <td>
        <form action = "{{ route('deleteServicio', $servicio->id) }}" method='post' onsubmit="return confirm('Seguro que quieres eliminar los datos del Cliente?;')">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </td>
    </tr>

   @endforeach
  </tbody>
 
@endsection