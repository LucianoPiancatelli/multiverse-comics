@extends('layouts.app')

@section('title', $comic->title . ' | Multiverse Comics')

@php use Illuminate\Support\Str; @endphp

@section('content')
    <section class="container">
        <a href="{{ url()->previous() === url()->current() ? route('comics.index') : url()->previous() }}" class="btn btn-link text-decoration-none text-secondary mb-4">&larr; Volver</a>

        <div class="row g-5 align-items-start">
            <div class="col-md-5">
                <figure class="comic-cover shadow-strong rounded-4" style="background-image: url('{{ $comic->cover_image_url }}');">
                    <img src="{{ $comic->cover_image_url }}" alt="Portada de {{ $comic->title }}" onerror="this.src='https://via.placeholder.com/600x900?text=Multiverse+Comics'; this.onerror=null;">
                </figure>
            </div>
            <div class="col-md-7">
                <span class="badge text-bg-secondary text-uppercase mb-3">{{ strtoupper($comic->universe) }}</span>
                <h1 class="h2 text-light">{{ $comic->title }}</h1>
                <p class="text-secondary fs-6 mb-4">{{ $comic->description }}</p>

                <ul class="list-unstyled text-secondary small mb-4">
                    @if($comic->series)
                        <li><strong class="text-light">Serie:</strong> {{ $comic->series }}</li>
                    @endif
                    @if($comic->writer)
                        <li><strong class="text-light">Guion:</strong> {{ $comic->writer }}</li>
                    @endif
                    @if($comic->artist)
                        <li><strong class="text-light">Arte:</strong> {{ $comic->artist }}</li>
                    @endif
                    @if($comic->release_date)
                        <li><strong class="text-light">Lanzamiento:</strong> {{ $comic->release_date->format('d/m/Y') }}</li>
                    @endif
                </ul>

                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="display-6 fw-bold text-accent">{{ $comic->formatted_price }}</span>
                    <span class="badge text-bg-dark">Stock disponible: {{ $comic->stock }}</span>
                </div>

                <form action="{{ route('cart.store') }}" method="post" class="d-flex flex-wrap align-items-center gap-3">
                    @csrf
                    <input type="hidden" name="comic_id" value="{{ $comic->id }}">
                    <div class="quantity-input">
                        <label for="quantity" class="form-label text-secondary small mb-1">Cantidad</label>
                        <input id="quantity" type="number" name="quantity" value="1" min="1" max="{{ $comic->stock }}" class="form-control form-control-lg bg-dark text-light border-secondary">
                    </div>
                    <button type="submit" class="btn btn-lg btn-glow-primary px-5">Agregar al carrito</button>
                    <a href="{{ route('cart.index') }}" class="btn btn-lg btn-outline-light">Ver carrito</a>
                </form>

                <div class="mt-5">
                    <h2 class="h5 text-light mb-3">¿Por qué nos encanta?</h2>
                    <p class="text-secondary">
                        Cada compra en Multiverse Comics incluye acceso a nuestra comunidad privada, guías de lectura personalizadas y alertas de próximas ediciones relacionadas con este título.
                    </p>
                </div>
            </div>
        </div>

        @if($related->isNotEmpty())
            <div class="mt-5">
                <h2 class="section-title text-light mb-4">Otros títulos del mismo universo</h2>
                <div class="row g-4">
                    @foreach($related as $other)
                        <div class="col-md-3">
                            <div class="related-card h-100">
                                <div class="ratio ratio-3x4 rounded-3 overflow-hidden mb-3">
                                    <img src="{{ $other->cover_image_url }}" class="w-100 h-100 object-fit-cover" alt="Portada de {{ $other->title }}" onerror="this.src='https://via.placeholder.com/400x600?text=Multiverse+Comics'; this.onerror=null;">
                                </div>
                                <h3 class="h6 text-light">{{ $other->title }}</h3>
                                <span class="badge text-bg-secondary mb-2">{{ strtoupper($other->universe) }}</span>
                                <p class="text-secondary small mb-3">{{ Str::limit($other->description, 70) }}</p>
                                <a href="{{ route('comics.show', $other) }}" class="btn btn-sm btn-outline-light">Explorar</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
