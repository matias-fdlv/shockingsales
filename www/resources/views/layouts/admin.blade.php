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
        <h1 class="logo">ShockingSales - Administrador </h1>

        <nav>
            <ul>
                <li>
                    <div class="container">
                    
                </li>
                <li><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li><a href="{{ route('registro.admin') }}">Crea un nuevo Administrador</a></li>
                <li><a href="{{ route('personas.index') }}">Usuarios de ShockingSales</a></li>
                <li><a href="{{ url('/admin/dashboard') }}">Perfil</a></li>

                <li><a href="">Wishlist</a></li>


                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline">
                        @csrf
                        <button class="button" type="submit">Salir</button>
                    </form>
                </li>

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
