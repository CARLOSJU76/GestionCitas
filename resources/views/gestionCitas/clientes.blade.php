@extends('layouts.clientenav')
@section('content')
    Sección Clientes!<br>    
    En esta sección puedes consultar los Clientes y/o pacientes.<br>

    <h3>Consultar Clientes</h3>
    <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Código</th>
      <th scope="col">Nombre del Cliente</th>
      <th scope="col">Teléfono</th>
    </tr>
  </thead>
  <tbody>
    @foreach($clientes as $cliente)
    
    <tr>
      <th scope="row">{{$cliente->id}}</th>
      <td>{{$cliente->nombre}}</td>
      <td>{{$cliente->telefono}}</td>
      <td>
        <form action = "{{ route('deleteCliente', $cliente->id) }}" method='post' onsubmit="return confirm('Seguro que quieres eliminar los datos del Cliente?;')">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </td>
    </tr>

   @endforeach
  </tbody>
</table>
    
@endsection