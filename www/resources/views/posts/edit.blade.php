@extends('layout')
 
@section('content')
<h1>Editar Post</h1>
 
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 
<form action="{{ route('posts.update', $post) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $post->titulo) }}">
    </div>
    <div class="mb-3">
        <label for="contenido" class="form-label">Contenido</label>
        <textarea name="contenido" class="form-control">{{ old('contenido', $post->contenido) }}</textarea>
    </div>
    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection