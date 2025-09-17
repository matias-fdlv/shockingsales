<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Aplicación')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">MiApp</a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('registro.usuario') }}">Registro Usuario</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('registro.admin') }}">Registro Admin</a></li>
                    @endguest

                    @auth
                        <li class="nav-item"><span class="nav-link">Hola, {{ Auth::user()->Nombre }}</span></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-link nav-link" type="submit">Cerrar sesión</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Contenido dinámico --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; {{ date('Y') }} Mi Aplicación. Todos los derechos reservados.</p>
    </footer>

</body>
</html>