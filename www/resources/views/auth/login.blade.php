@extends('layouts.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Iniciar Sesión</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="Mail" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control @error('Mail') is-invalid @enderror" 
                               id="Mail" name="Mail" value="{{ old('Mail') }}" required autofocus>
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

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('register') }}">¿No tienes cuenta? Regístrate aquí</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection