<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ShockingSales')</title>

    {{-- Cargamos el CSS estático desde public/ --}}
 @vite('resources/css/plantilla.css')

</head>

<body>

    <header>
        <h1 class="logo">ShockingSales</h1>

        <nav>
            <ul>
                <li>
                    <div class="container">
                        <form class="search" action="{{ url('/buscar') }}" method="GET">
                            <input type="text" name="q" placeholder="Buscar producto, modelo o SKU…"
                                value="{{ request('q') }}">
                            <button class="button" type="submit">Buscar</button>
                        </form>
                </li>
                <li><a href="{{ url('/') }}">Home</a></li>

                <!-- Vista de un usuario no autenticado, el @ guest indica que lo que se muestra a un usuario no autenticado.
                    En este caso muestra las opciones de login y registrarse -->
                @guest
                    <li><a href="{{ route('login') }}">Entrar</a></li>
                    <li><a href="{{ route('register') }}">Registrarse</a></li>
                @endguest

                <!-- Vista de un usuario autenticado, el @ auth indica que lo que se muestra a un usuario autenticado.
                    En este caso muestra las opciones de personas que es el sistema hecho hasta ahora y salir para cerrar sesion -->
                @auth
                    <li><a href="{{ route('personas.index') }}">Personas</a></li>
                    <li><a href="">Wishlist</a></li>


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
