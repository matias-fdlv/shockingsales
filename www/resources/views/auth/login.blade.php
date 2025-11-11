@extends('layouts.layout')

@section('title', 'Entrar – ShockingSales')

@push('styles')
  @vite('resources/css/login.css')  
@endpush

@push('scripts')
  @vite('resources/js/vistaContra.js')  
@endpush

@section('content')
<section id="auth">
  <div class="auth-wrap">
    <div class="auth-card">
      <aside class="auth-side">
        <h1>Bienvenido otra vez</h1>
        <p>Compará precios en segundos y gestioná tu wishlist.</p>
        <ul class="auth-bullets">
          <li>• Sin carrito: te llevamos a la tienda oficial</li>
          <li>• Ve los productos de cada tienda y elige con comodidad</li>
          <li>• Compras informadas, sin sorpresas</li>
        </ul>
      </aside>

      <form class="auth-form" method="POST" action="{{ route('login') }}" novalidate>
        @csrf
        <h2>Iniciar sesión</h2>

        <label for="email">Correo electrónico</label>
        <input id="email" name="Mail" type="email" class="form-control"
               placeholder="tucorreo@ejemplo.com" value="{{ old('email') }}" required>
        @error('email') <small class="error">{{ $message }}</small> @enderror

        <label for="password">Contraseña</label>
        <div class="password-group">
          <input id="password" name="password" type="password" class="form-control"
                 placeholder="••••••••" required>
          <button type="button" class="toggle-pass" aria-label="Mostrar u ocultar">👁</button>
        </div>
        @error('password') <small class="error">{{ $message }}</small> @enderror

        <div class="auth-meta">
          <label><input type="checkbox" id="remember" name="remember"> Recordarme</label>
          <a href="#" class="link">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="button">Entrar</button>

        <p class="auth-alt">¿No tenés cuenta? <a href="{{ route('registro.usuario') }}">Registrate</a></p>
      </form>
    </div>
  </div>
</section>
@endsection
