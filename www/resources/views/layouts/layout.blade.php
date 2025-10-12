<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'ShockingSales')</title>

    {{-- CSS base de tu app (elige el que uses por defecto) --}}
    @vite('resources/css/plantilla.css')

    {{-- Espacio para inyectar estilos por vista si hace falta --}}
    @stack('styles')
</head>
<body>

    <header>
        <div class="header-inner">
            <a href="{{ url('/') }}" class="brand" aria-label="Inicio">
                <img src="{{ asset('imagenes/Logo1.JPG') }}" alt="ShockingSales" class="logo-img">
            </a>
        </div>
    </header>

    <main>
        <section class="container">
            @yield('content')
        </section>
    </main>

    <footer>
        © {{ date('Y') }} ShockingSales
    </footer>

    {{-- Espacio para inyectar scripts por vista si hace falta --}}
    @stack('scripts')
</body>
</html>
