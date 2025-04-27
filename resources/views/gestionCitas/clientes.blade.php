@extends('layouts.clientenav')
@section('content')
    Sección Clientes!<br>    
    En esta sección puedes consultar los Clientes y/o pacientes.<br>

    <h3>Consultar Clientes</h3>
    <table class="table table-bordered">
  <thead>
    <tr>
                    <th>Nombre</th>
                    <th>Identificación</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Perfil</th>
                    <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($clientes as $cliente)
    
    <tr>
      
      <td>{{$cliente->nombre}}</td>
      <td>{{ $cliente->identificacion }}</td>
      <td>{{ $cliente->email }}</td>
      <td>{{$cliente->telefono}}</td>
      <td>{{ $cliente->perfil ? $cliente->perfil->nombre : 'No asignado' }}</td>
      
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