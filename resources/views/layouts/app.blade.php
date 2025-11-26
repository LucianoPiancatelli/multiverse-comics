<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Multiverse Comics: tienda y blog especializado en comics de DC y Marvel.">
    <title>@yield('title', 'Multiverse Comics')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-dark text-light">
    <header class="shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-dark bg-gradient-primary py-3">
            <div class="container">
                <a class="navbar-brand fs-3" href="{{ route('home') }}">
                    <span class="brand-highlight">Multiverse</span> Comics
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('comics.*') ? 'active' : '' }}" href="{{ route('comics.index') }}">Tienda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}" href="{{ route('posts.index') }}">Blog &amp; Noticias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                                Carrito
                                @php $cartCount = collect(session('cart', []))->sum('quantity'); @endphp
                                <span class="badge text-bg-light ms-1">{{ $cartCount }}</span>
                            </a>
                        </li>

                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="badge bg-secondary text-uppercase">{{ auth()->user()->role }}</span>
                                    <span>{{ auth()->user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if(auth()->user()->isAdmin())
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Panel de Admin</a></li>
                                    @endif
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button class="dropdown-item" type="submit">Cerrar sesion</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item my-2 my-lg-0 ms-lg-2">
                                <a class="btn btn-outline-light btn-sm px-3 w-100" href="{{ route('login') }}">Ingresar</a>
                            </li>
                            <li class="nav-item my-2 my-lg-0">
                                <a class="btn btn-sm btn-light text-dark px-3 w-100" href="{{ route('register') }}">Crear cuenta</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-5">
        @if(session('status'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <strong>Listo!</strong> {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <strong>Ups...</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-black text-center text-secondary py-4 mt-auto">
        <div class="container">
            <p class="mb-1">&copy; {{ now()->year }} Multiverse Comics. Todos los derechos reservados.</p>
            <p class="mb-0 small">
                Piancatelli Luciano, Gonzalez Brisa, Martinez Tomas, Parcial 2 Portales y Comercio Electronico -DWT4AP
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
