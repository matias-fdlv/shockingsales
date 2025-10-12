@extends('layouts.layout')

@section('content')
    <div class="container" style="max-width: 720px">
        @if (session('success'))
            <div
                style="background:#e6ffed;border:1px solid #34d399;padding:.75rem 1rem;margin-bottom:1rem;border-radius:.5rem;">
                {{ session('success') }}
            </div>
        @endif

        <h1 style="margin-bottom:.75rem;">Mi perfil</h1>

        <div style="display:flex;gap:1rem;align-items:center;margin-bottom:1rem;">
            <div>
                <p><strong>Nombre:</strong> {{ $user->Nombre }}</p>
                <p><strong>Email:</strong> {{ $user->Mail }}</p>

            </div>
        </div>

        <div style="display:flex; gap:.5rem;">
            <a href="{{ route('perfil.editar') }}"
                style="display:inline-block;padding:.5rem 1rem;border:1px solid #111;border-radius:.5rem;text-decoration:none;">
                Editar perfil
            </a>
            <a href="{{ url()->previous() }}"
                style="display:inline-block;padding:.5rem 1rem;border:1px solid #bbb;border-radius:.5rem;text-decoration:none;">
                Volver
            </a>
        </div>
    </div>
@endsection
