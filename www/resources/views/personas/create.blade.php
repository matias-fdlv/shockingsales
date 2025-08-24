@extends('layout')
 
@section('content')
<h1>Crear nueva persona</h1>
 
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 
<form action="{{ route('personas.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="Nombre" class="form-label">Nombre</label>
        <input type="text" name="Nombre" class="form-control" value="{{ old('Nombre') }}">
    </div>

    <div class="mb-3">
        <label for="Mail" class="form-label">Email</label>
        <input type="text" name="Mail" class="form-control" value="{{ old('Mail') }}">
    </div>

        <div class="mb-3">
        <label for="Contraseña" class="form-label">Contraseña</label>
        <input type="text" name="Contraseña" class="form-control" value="{{ old('Contraseña') }}">
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('personas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection