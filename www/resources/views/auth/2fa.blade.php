@extends('layouts.layout')

@section('title', 'Comprobación de Usuario')

@push('styles')
    @vite('resources/css/2fa.css')
@endpush

@section('content')
    <div class="max-w-md mx-auto py-10">
        @if (session('status'))
            <div class="alert alert-success mb-4">{{ session('status') }}</div>
        @endif

        <h1 class="text-2xl font-bold mb-4">Verificación en dos pasos</h1>

        @if (!empty($showQr))
            <p class="mb-4">Escanea este QR con tu app TOTP (Google Authenticator, etc.).</p>

            <div class="mb-4" style="max-width:260px">
                {!! $qrSvg !!}
            </div>

            <p class="text-sm text-gray-600 mb-6">
                ¿No puedes escanear? Ingresa este código manualmente:
                <code class="px-2 py-1 bg-gray-100 rounded">{{ $secret ?? '' }}</code>
            </p>
        @else
            <p class="mb-4">Ingresa el código de tu app de autenticación.</p>
        @endif

        <form method="POST" action="{{ route('2fa.verify') }}" class="space-y-4" autocomplete="off">
            @csrf
            <label class="block">
                <span class="block mb-1">Código de 6 dígitos</span>
                <input name="code" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code"
                    class="w-full border rounded px-3 py-2" placeholder="123456" required autofocus>
            </label>

            @error('code')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-primary w-full">Verificar</button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm underline">Cambiar de cuenta</a>
        </div>
    </div>
@endsection
