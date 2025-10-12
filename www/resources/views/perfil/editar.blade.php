@extends('layouts.layout')

@section('content')
<div class="container" style="max-width: 720px">

    <h1 style="margin-bottom:1rem;">Editar perfil</h1>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div style="background:#fff7ed;border:1px solid #f59e0b;padding:.75rem 1rem;margin-bottom:1rem;border-radius:.5rem;">
            <ul style="margin:0;padding-left:1.25rem;">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('perfil.actualizar') }}" style="display:grid;gap:1rem;">
        @csrf
        @method('PUT')

        <div>
            <label for="Nombre" style="display:block;margin-bottom:.25rem;">Nombre</label>
            <input id="Nombre" name="Nombre" type="text"
                   value="{{ old('Nombre', auth()->user()->Nombre) }}"
                   style="width:100%;padding:.5rem;border:1px solid #ccc;border-radius:.375rem;">
        </div>

        <div>
            <label for="Mail" style="display:block;margin-bottom:.25rem;">Email</label>
            <input id="Mail" name="Mail" type="email"
                   value="{{ old('Mail', auth()->user()->Mail) }}"
                   style="width:100%;padding:.5rem;border:1px solid #ccc;border-radius:.375rem;">
        </div>

        <hr style="border:none;border-top:1px solid #e5e7eb;margin: .25rem 0 0.5rem;">

        <div>
            <label for="password" style="display:block;margin-bottom:.25rem;">Nueva contraseña (opcional)</label>
            <input id="password" name="password" type="password"
                   placeholder="Mínimo 8 caracteres"
                   style="width:100%;padding:.5rem;border:1px solid #ccc;border-radius:.375rem;">
        </div>

        <div>
            <label for="password_confirmation" style="display:block;margin-bottom:.25rem;">Confirmar nueva contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                   style="width:100%;padding:.5rem;border:1px solid #ccc;border-radius:.375rem;">
        </div>

        <div style="display:flex;gap:.5rem;">
            <button type="submit" style="padding:.5rem 1rem;border:1px solid #111;border-radius:.5rem;background:#111;color:#fff;">
                Guardar cambios
            </button>
            <a href="{{ route('perfil.mostrar') }}" style="display:inline-block;padding:.5rem 1rem;border:1px solid #bbb;border-radius:.5rem;text-decoration:none;">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
