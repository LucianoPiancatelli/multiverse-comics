@extends('layouts.app')

@section('title', 'Blog y noticias | Multiverse Comics')

@php use Illuminate\Support\Str; @endphp

@section('content')
    <section class="container">
        <div class="row align-items-center mb-4">
            <div class="col">
                <p class="text-uppercase text-accent small fw-semibold mb-1">Blog &amp; novedades</p>
                <h1 class="h2 text-light mb-0">Historias, rese&ntilde;as y gu&iacute;as para fans del multiverso</h1>
            </div>
        </div>

        <form class="row g-3 align-items-end bg-secondary-subtle rounded-4 p-4 filter-bar mb-5" method="get" action="{{ route('posts.index') }}">
            <div class="col-md-4">
                <label for="post-search" class="form-label text-light">Buscar</label>
                <input type="search" name="search" id="post-search" value="{{ $filters['search'] ?? '' }}" class="form-control form-control-lg bg-dark text-light border-0" placeholder="Secret Wars, Batman, consejos...">
            </div>
            <div class="col-md-4">
                <label for="category" class="form-label text-light">Categor&iacute;a</label>
                <select name="category" id="category" class="form-select form-select-lg bg-dark text-light border-0">
                    <option value="">Todas</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" @selected(($filters['category'] ?? null) === $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-grid">
                <button type="submit" class="btn btn-lg btn-glow-primary">Filtrar art&iacute;culos</button>
                @if(array_filter($filters))
                    <a href="{{ route('posts.index') }}" class="btn btn-link text-accent mt-2">Limpiar filtros</a>
                @endif
            </div>
        </form>

        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <article class="post-card h-100">
                        <div class="ratio ratio-16x9 overflow-hidden rounded-3 mb-3">
                            <img src="{{ $post->cover_image_url }}" class="w-100 h-100 object-fit-cover" alt="Imagen de {{ $post->title }}">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge text-bg-accent">{{ $post->category }}</span>
                            <small class="text-secondary">{{ optional($post->published_at)->format('d/m/Y') }}</small>
                        </div>
                        <h2 class="h5 text-light">{{ $post->title }}</h2>
                        <p class="text-secondary small">{{ Str::limit(strip_tags($post->excerpt), 120) }}</p>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-light mt-auto">Leer art&iacute;culo</a>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Todav&iacute;a no publicamos art&iacute;culos con esos filtros.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-5">
            {{ $posts->links() }}
        </div>
    </section>
@endsection
