@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Registrarse</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="Nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control @error('Nombre') is-invalid @enderror" 
                               id="Nombre" name="Nombre" value="{{ old('Nombre') }}" required autofocus>
                        @error('Nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Mail" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control @error('Mail') is-invalid @enderror" 
                               id="Mail" name="Mail" value="{{ old('Mail') }}" required>
                        @error('Mail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">¿Ya tienes cuenta? Inicia sesión aquí</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection