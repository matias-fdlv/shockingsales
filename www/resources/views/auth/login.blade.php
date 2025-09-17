@extends('layouts.layout')

@section('title', 'Login')

@section('content')
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4>Iniciar Sesión</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
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

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Recuérdame</label>
            </div>

            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
    </div>
</div>
@endsection
