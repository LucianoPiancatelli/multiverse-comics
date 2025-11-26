@extends('layouts.app')

@section('title', 'Catálogo de cómics | Multiverse Comics')

@php use Illuminate\Support\Str; @endphp

@section('content')
    <section class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <p class="text-uppercase text-accent small fw-semibold mb-1">Tienda multiverso</p>
                <h1 class="h2 text-light mb-0">Explorá nuestra selección de cómics</h1>
            </div>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-light">
                Ver carrito
            </a>
        </div>

        <form class="row g-3 align-items-end bg-secondary-subtle rounded-4 p-4 filter-bar mb-5" method="get" action="{{ route('comics.index') }}">
            <div class="col-md-4">
                <label for="search" class="form-label text-light">Buscar</label>
                <input type="search" name="search" id="search" value="{{ $filters['search'] ?? '' }}" class="form-control form-control-lg bg-dark text-light border-0" placeholder="Batman, Spider-Man, evento...">
            </div>
            <div class="col-md-3">
                <label for="universe" class="form-label text-light">Universo</label>
                <select name="universe" id="universe" class="form-select form-select-lg bg-dark text-light border-0">
                    <option value="">Todos</option>
                    <option value="dc" @selected(($filters['universe'] ?? null) === 'dc')>DC Comics</option>
                    <option value="marvel" @selected(($filters['universe'] ?? null) === 'marvel')>Marvel</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-light">Orden</label>
                <select name="sort" class="form-select form-select-lg bg-dark text-light border-0">
                    <option value="">Alfabético</option>
                    <option value="release" @selected(request('sort') === 'release')>Más reciente</option>
                    <option value="price_low" @selected(request('sort') === 'price_low')>Precio: Menor a Mayor</option>
                    <option value="price_high" @selected(request('sort') === 'price_high')>Precio: Mayor a Menor</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-glow-primary btn-lg">Filtrar</button>
                @if(array_filter($filters))
                    <a href="{{ route('comics.index') }}" class="btn btn-link text-decoration-none text-accent mt-2">Limpiar filtros</a>
                @endif
            </div>
        </form>

        <div class="row g-4">
            @forelse($comics as $comic)
                <div class="col-md-4 col-lg-3">
                    <div class="comic-card h-100">
                        <div class="ratio ratio-3x4 rounded-3 overflow-hidden mb-3">
                            <img src="{{ $comic->cover_image_url }}" class="w-100 h-100 object-fit-cover" alt="Portada de {{ $comic->title }}" onerror="this.src='https://via.placeholder.com/400x600?text=Multiverse+Comics'; this.onerror=null;">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge text-bg-secondary">{{ strtoupper($comic->universe) }}</span>
                            <span class="badge text-bg-dark">Stock: {{ $comic->stock }}</span>
                        </div>
                        <h2 class="h5 text-light">{{ $comic->title }}</h2>
                        <p class="text-secondary small mb-3">{{ Str::limit($comic->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold text-accent">{{ $comic->formatted_price }}</span>
                            <a href="{{ route('comics.show', $comic) }}" class="btn btn-sm btn-outline-light">Ver más</a>
                        </div>
                        <form action="{{ route('cart.store') }}" method="post" class="d-flex gap-2">
                            @csrf
                            <input type="hidden" name="comic_id" value="{{ $comic->id }}">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $comic->stock }}" class="form-control form-control-sm bg-dark text-light border-secondary" aria-label="Cantidad">
                            <button type="submit" class="btn btn-sm btn-glow-primary flex-grow-1">Agregar</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No encontramos cómics que coincidan con tu búsqueda.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-5">
            {{ $comics->links() }}
        </div>
    </section>
@endsection
