<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ShockingSales')</title>

    @vite('resources/css/adminStyle.css')
    @stack('styles')
</head>

<body>

    <header id="site-header">
        <div id="header-bar">
            <a href="{{ url('/') }}" id="brand" aria-label="Inicio">
                <img src="{{ asset('imagenes/logo1.png') }}" alt="ShockingSales" id="logo">
                <span id="tagline">Comparador · Admin</span>
            </a>

            <ul class="user-actions">
                <li><a href="{{ route('perfil.mostrar') }}" id="perfil">Mi perfil</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="button" type="submit">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <nav id="primary-nav" aria-label="Principal">
        <ul id="menu">
            <li><a href="{{ url('/') }}" aria-current="{{ request()->is('/') ? 'page' : '' }}" id="home">Home</a></li>
            <li id="panel">Panel de Configuración</li>
            <li><a href="{{ route('registro.admin') }}" id="registroAdmin">Nuevo Administrador</a></li>


        </ul>
    </nav>

    <main id="site-main">
        <section id="content" class="container">
            @yield('content')
        </section>
    </main>


    <footer id="site-footer">
        © {{ date('Y') }} ShockingSales
    </footer>

</body>

</html>
