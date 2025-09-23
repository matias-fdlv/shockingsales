<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'ShockingSales')</title>

    {{-- CSS: admin vs resto --}}
    @auth('admin')
        @vite('resources/css/adminStyle.css')
    @else
        @vite('resources/css/plantilla.css')
    @endauth
</head>

<body>
    <header>
        <h1 class="logo">ShockingSales</h1>

        <nav>
            <ul>

                {{-- Invitado real: sin sesión en web ni admin --}}

                @if (!Auth::guard('web')->check() && !Auth::guard('admin')->check())
                    <li>
                        <div class="container">
                            <form class="search" action="{{ url('/buscar') }}" method="GET">
                                <input type="text" name="q" placeholder="Buscar producto, modelo o SKU…"
                                    value="{{ request('q') }}">
                                <button class="button" type="submit">Buscar</button>
                            </form>
                        </div>
                    </li>

                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('login') }}">Entrar</a></li>
                    <li><a href="{{ route('registro.usuario') }}">Registrarse como Usuario</a></li>
                @endif

                {{-- Usuario autenticado (NO admin) --}}
                @if (Auth::guard('web')->check() && !Auth::guard('admin')->check())
                    <li>
                        <div class="container">
                            <form class="search" action="{{ url('/buscar') }}" method="GET">
                                <input type="text" name="q" placeholder="Buscar producto, modelo o SKU…"
                                    value="{{ request('q') }}">
                                <button class="button" type="submit">Buscar</button>
                            </form>
                        </div>
                    </li>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="#">Wishlist</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline">
                            @csrf
                            <button class="button" type="submit">Salir</button>
                        </form>
                    </li>
                @endif

                {{-- Administrador (guard admin) --}}
                @auth('admin')
                    <li><a href="{{ url('/') }}">Home</a></li>

                    <li><a href="{{ route('VistaAdmin.homeAdmin') }}">Panel</a></li>
                    <li><a href="{{ route('registro.admin') }}">Crear Administrador</a></li>
                    <li><a href="{{ route('VistaAdmin.homeAdmin') }}">Perfil</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline">
                            @csrf
                            <button class="button" type="submit">Salir</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </nav>
    </header>

    <main>
        <section class="container">
            @yield('content')
        </section>
    </main>

    <footer>
        © {{ date('Y') }} ShockingSales
    </footer>
</body>

</html>
