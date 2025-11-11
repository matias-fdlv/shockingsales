@extends('layouts.layout')

@section('content')
<div class="container">
    <h1 class="title">Editar perfil</h1>

    @if ($errors->any())
        <div class="alert alert-warning" role="alert">
            <ul class="alert-list">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('perfil.actualizar') }}" class="form" novalidate autocomplete="off">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="Nombre">Nombre <span class="hint">(opcional)</span></label>
            <input id="Nombre" name="Nombre" type="text"
                   value="{{ old('Nombre') }}"
                   placeholder="Escribe solo si quieres cambiarlo"
                   autocomplete="off" autocapitalize="none" spellcheck="false">
        </div>

        <div class="form-group">
            <label for="Mail">Email <span class="hint">(opcional)</span></label>
            <input id="Mail" name="Mail" type="email"
                   value="{{ old('Mail') }}"
                   placeholder="Escribe solo si quieres cambiarlo"
                   autocomplete="off" autocapitalize="none" spellcheck="false">
        </div>

        <hr class="divider">

        <div class="form-group">
            <label for="password">Nueva contraseña <span class="hint">(opcional)</span></label>
            <input id="password" name="password" type="password"
                   placeholder="Mínimo 8 caracteres"
                   autocomplete="new-password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar nueva contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                   autocomplete="new-password">
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('perfil.mostrar') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
