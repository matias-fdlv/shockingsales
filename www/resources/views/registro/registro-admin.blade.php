@extends('layouts.registro')

@section('title', 'Registro Administrador')

@section('content')
<div class="card shadow">
    <div class="card-header bg-danger text-white">
        <h4>Registro de Administrador</h4>
    </div>
    <div class="card-body">

        {{-- Mensajes flash --}}
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        {{-- /Mensajes flash --}}

        <form method="POST" action="{{ route('registro.admin') }}">
            @csrf
            <div class="mb-3">
                <label for="Nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="Nombre" name="Nombre" value="{{ old('Nombre') }}" required>
                @error('Nombre') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="Mail" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="Mail" name="Mail" value="{{ old('Mail') }}" required>
                @error('Mail') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-danger">Registrar Administrador</button>
        </form>
    </div>
</div>
@endsection
