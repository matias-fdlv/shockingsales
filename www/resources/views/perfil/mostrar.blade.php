@extends('layouts.layout')

@section('content')
    <div class="container" style="max-width: 720px">
        @if (session('success'))
            <div style="background:#e6ffed;border:1px solid #34d399;padding:.75rem 1rem;margin-bottom:1rem;border-radius:.5rem;">
                {{ session('success') }}
            </div>
        @endif

        <h1 style="margin-bottom:.75rem;">Mi perfil</h1>

        <div>
            <div>
                <p><strong>Nombre:</strong> {{ $user->Nombre }}</p>
                <p><strong>Email:</strong> {{ $user->Mail }}</p>

            </div>
        </div>

        <div>
            <a href="{{ route('perfil.editar') }}">Editar perfil</a>
            <a href="{{ url()->previous() }}">Volver</a>
        </div>
    </div>
@endsection
