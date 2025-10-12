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
</head>

<body>
    @php
        $isAdmin = Auth::guard('admin')->check();
        $isUser = Auth::guard('web')->check();
    @endphp

    <header>
        <div class="header-inner">

            <a href="{{ url('/') }}" class="brand" aria-label="Inicio">
                <img src="{{ asset('imagenes/Logo1.JPG') }}" alt="ShockingSales" class="logo-img">
            </a>

            <nav aria-label="Principal">
                <ul class="menu">
                    <li><a href="{{ url('/') }}">Home</a></li>

                    <!--Invitado  -->
                    @guest('web')
                        @guest('admin')
                            <li><a href="{{ route('login') }}">Entrar</a></li>
                            <li><a href="{{ route('registro.usuario') }}">Registrarse</a></li>
                        @endguest
                    @endguest

                    <!--Usuario autenticad. Independientemente si es admin o usuario-->
                    @if ($isUser && !$isAdmin)
                        <li><a href="{{ route('perfil.mostrar') }}">Mi perfil</a></li>
                        <li><a href="#">Wishlist</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                                @csrf
                                <button class="button" type="submit">Salir</button>
                            </form>
                        </li>
                    @endif

                    <!--Administrador autenticado -->
                    @if ($isAdmin)
                        <li><a href="{{ route('VistaAdmin.homeAdmin') }}">Panel</a></li>
                        <li><a href="{{ route('registro.admin') }}">Crear Admin</a></li>
                        <li><a href="{{ route('VistaAdmin.homeAdmin') }}">Perfil</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                                @csrf
                                <button class="button" type="submit">Salir</button>
                            </form>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>


    </header>

    <main>

        <!-- Mostrar a todos menos a Admin -->
        @unless ($isAdmin)
            <div class="container">
                <form class="search" action="{{ url('/buscar') }}" method="GET" role="search">
                    <input type="text" name="q" placeholder="Buscar producto, modelo o SKU…"
                        value="{{ request('q') }}" aria-label="Buscar">
                    <button class="button" type="submit">Buscar</button>
                </form>
            </div>
        @endunless
        <section class="container">

            @yield('content')
        </section>
    </main>

    <footer>
        © {{ date('Y') }} ShockingSales
    </footer>


</body>

</html>
