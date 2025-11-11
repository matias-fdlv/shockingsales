<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShockingSales')</title>

    @auth('admin')
        @vite('resources/css/adminStyle.css')
    @else
        @vite('resources/css/plantilla.css')
    @endauth    
    
    @vite('resources/js/user-menu.js')

</head>
<body>
@php
    $isAdmin = Auth::guard('admin')->check();
    $isUser  = Auth::guard('web')->check();
@endphp

<header id="site-header">
    <div id="header-bar" class="container">
        <a href="{{ url('/') }}" id="brand" aria-label="Inicio">
            <img src="{{ asset('imagenes/logo1.png') }}" alt="ShockingSales" id="logo">
        </a>

        <nav id="primary-nav" aria-label="Principal">
            <ul id="menu">
                <li><a href="{{ url('/') }}">Home</a></li>

                @guest('web')
                    @guest('admin')
                        <li><a href="{{ route('login') }}">Entrar</a></li>
                        <li><a href="{{ route('registro.usuario') }}">Registrarse</a></li>
                    @endguest
                @endguest

                {{-- ADMIN: solo deja accesos del panel en el menú (perfil/cerrar van arriba a la derecha) --}}
                @if ($isAdmin)
                    <li><a href="{{ route('registro.admin') }}">Crear Admin</a></li>
                    <li><a href="{{ route('VistaAdmin.homeAdmin') }}">Panel</a></li>
                @endif
            </ul>
        </nav>

        @if ($isAdmin)
            <ul class="user-actions">
                <li><a href="{{ route('perfil.mostrar') }}" id="perfil">Mi perfil</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="button">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
@elseif ($isUser)
    <div class="user-menu" id="userMenu">
        <button type="button"
                id="userTrigger"
                class="user-select"
                aria-haspopup="menu"
                aria-expanded="false">
            <span class="avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </span>
            <span class="label">Cuenta</span>
            <span class="caret" aria-hidden="true"></span>
        </button>

        <div class="user-dropdown" id="userDropdown" role="menu">
            <a href="{{ route('perfil.mostrar') }}" class="menu-item" role="menuitem">Perfil</a>
            <a href="#" class="menu-item" role="menuitem">Wishlist</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="menu-item" role="menuitem">Salir</button>
            </form>
        </div>
    </div>
@endif

    </div>
</header>

<main id="site-main">
    @yield('content')
</main>

<footer id="site-footer">
    <div class="container">
        <div id="footer-links">
            <a href="{{ url('/terminos') }}">Términos</a>
            <a href="{{ url('/privacidad') }}">Privacidad</a>
            <a href="{{ url('/contacto') }}">Contacto</a>
        </div>
        <div id="copyright">© {{ date('Y') }} ShockingSales</div>
    </div>
</footer>
</body>
</html>
