@extends('layouts.app')

@section('title', 'Multiverse Comics | Tienda y blog de heroes')

@php use Illuminate\Support\Str; @endphp

@section('content')
    <section class="container">
        <div class="row align-items-center g-4 hero-section">
            <div class="col-lg-6">
                <p class="text-uppercase text-accent fw-semibold mb-2">Bienvenido al cruce de mundos</p>
                <h1 class="display-4 fw-bold text-light mb-3">Descubri el proximo capitulo de tu multiverso favorito</h1>
                <p class="lead text-secondary mb-4">
                    Curamos los mejores lanzamientos y reliquias del universo DC y Marvel, sumando guias, noticias y contenido exclusivo para coleccionistas.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('comics.index') }}" class="btn btn-lg btn-glow-primary px-4">Explorar la tienda</a>
                    <a href="{{ route('posts.index') }}" class="btn btn-lg btn-outline-light px-4">Ultimas novedades</a>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-lg btn-light text-dark px-4">Ingresar</a>
                        <a href="{{ route('register') }}" class="btn btn-lg btn-outline-light px-4">Crear cuenta</a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6">
                @if($heroComic)
                    <div class="hero-card position-relative overflow-hidden rounded-4 shadow-strong">
                        <img src="{{ $heroComic->cover_image_url }}" alt="Portada de {{ $heroComic->title }}" class="img-fluid w-100 object-fit-cover hero-image" onerror="this.src='https://via.placeholder.com/1200x800?text=Multiverse+Comics'; this.onerror=null;">
                        <div class="hero-card-overlay">
                            <span class="badge text-bg-danger text-uppercase mb-2">Destacado</span>
                            <h2 class="h3 text-light mb-1">{{ $heroComic->title }}</h2>
                            <p class="text-secondary mb-3">{{ Str::limit($heroComic->description, 120) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-light fs-4">{{ $heroComic->formatted_price }}</span>
                                <a class="btn btn-outline-light btn-sm" href="{{ route('comics.show', $heroComic) }}">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="placeholder-card">
                        <p class="text-secondary">Pronto destacaremos nuestros lanzamientos mas epicos.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <span class="feature-icon text-danger">🔥</span>
                    <h3 class="h5 text-light">Ediciones Exclusivas</h3>
                    <p class="text-secondary mb-0">Preventas, portadas variantes y bundles coleccionistas con merchandising oficial.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <span class="feature-icon text-primary">📰</span>
                    <h3 class="h5 text-light">Ultimas Noticias</h3>
                    <p class="text-secondary mb-0">Actualizaciones semanales sobre series, peliculas y crossovers que afectan tu coleccion.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <span class="feature-icon text-warning">🎧</span>
                    <h3 class="h5 text-light">Asesoria a Fans</h3>
                    <p class="text-secondary mb-0">Te guiamos para expandir tu biblioteca fisica o digital con recomendaciones hechas a medida.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title text-light mb-0">Lanzamientos del multiverso</h2>
            <a href="{{ route('comics.index') }}" class="btn btn-link text-decoration-none text-accent">Ver catalogo completo</a>
        </div>
        <div class="row g-4">
            @forelse($newReleases as $comic)
                <div class="col-md-3">
                    <div class="comic-card h-100">
                        <div class="ratio ratio-3x4 overflow-hidden rounded-3 mb-3">
                            <img src="{{ $comic->cover_image_url }}" class="w-100 h-100 object-fit-cover" alt="Portada de {{ $comic->title }}" onerror="this.src='https://via.placeholder.com/400x600?text=Multiverse+Comics'; this.onerror=null;">
                        </div>
                        <span class="badge text-bg-secondary text-uppercase mb-2">{{ strtoupper($comic->universe) }}</span>
                        <h3 class="h5 text-light">{{ $comic->title }}</h3>
                        <p class="text-secondary small mb-3">{{ Str::limit($comic->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold text-light">{{ $comic->formatted_price }}</span>
                            <a href="{{ route('comics.show', $comic) }}" class="btn btn-sm btn-outline-light">Detalles</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-secondary">Aun no cargamos lanzamientos. Vuelve pronto!</p>
            @endforelse
        </div>
    </section>

    <section class="bg-gradient-secondary py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="section-title text-light mb-1">Suscribite al boletin Multiverse</h2>
                    <p class="text-secondary mb-0">Recibe alertas de lanzamientos, eventos y descuentos exclusivos.</p>
                </div>
                <form class="newsletter-form d-flex flex-wrap gap-2" action="#" method="post">
                    <input type="email" class="form-control form-control-lg bg-dark text-light border-secondary" placeholder="tuemail@multiverse.com" required>
                    <button type="submit" class="btn btn-lg btn-glow-primary">Quiero recibir novedades</button>
                </form>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title text-light mb-0">Ultimos articulos del blog</h2>
            <a href="{{ route('posts.index') }}" class="btn btn-link text-decoration-none text-accent">Explorar articulos</a>
        </div>
        <div class="row g-4">
            @forelse($latestPosts as $post)
                <div class="col-md-4">
                    <article class="post-card h-100">
                        <div class="ratio ratio-16x9 rounded-3 overflow-hidden mb-3">
                            <img src="{{ $post->cover_image_url }}" class="w-100 h-100 object-fit-cover" alt="Imagen del articulo {{ $post->title }}">
                        </div>
                        <span class="badge text-bg-accent mb-2">{{ $post->category }}</span>
                        <h3 class="h5 text-light">{{ $post->title }}</h3>
                        <p class="text-secondary small">{{ Str::limit(strip_tags($post->excerpt), 100) }}</p>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-light mt-auto">Leer articulo</a>
                    </article>
                </div>
            @empty
                <p class="text-secondary">Todavia no publicamos articulos.</p>
            @endforelse
        </div>
    </section>
@endsection
