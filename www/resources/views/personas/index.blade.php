@extends('layouts.layout')

 
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de personas</h1>
    <a href="{{ route('personas.create') }}" class="btn btn-primary">Nueva persona</a>
       <a href="{{ route('home') }}" class="btn btn-primary">Menú Principal</a>
</div>
 
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Mail</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($personas as $persona)
            <tr>
                <td>{{ $persona->Nombre }}</td>
                <td>{{ $persona->Mail }}</td>
                <td>
                    <a href="{{ route('personas.edit', $persona) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('personas.destroy', $persona) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este persona?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No hay personas disponibles.</td>
            </tr>
        @endforelse
    </tbody>
</table>
 
{{ $personas->links() }}
@endsection