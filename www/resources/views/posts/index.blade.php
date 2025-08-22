@extends('layout')
 
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Posts</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">Nuevo Post</a>
</div>
 
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Título</th>
            <th>Contenido</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($posts as $post)
            <tr>
                <td>{{ $post->titulo }}</td>
                <td>{{ Str::limit($post->contenido, 50) }}</td>
                <td>
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este post?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No hay posts disponibles.</td>
            </tr>
        @endforelse
    </tbody>
</table>
 
{{ $posts->links() }}
@endsection