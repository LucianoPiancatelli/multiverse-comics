@extends('layouts.app')

@section('title', $post->title . ' | Multiverse Comics')

@section('content')
    <section class="container">
        <a href="{{ url()->previous() === url()->current() ? route('posts.index') : url()->previous() }}" class="btn btn-link text-decoration-none text-secondary mb-4">&larr; Volver</a>

        <article class="post-detail bg-dark rounded-4 shadow-strong p-4 p-md-5">
            <header class="mb-4">
                <span class="badge text-bg-accent mb-2">{{ $post->category }}</span>
                <h1 class="text-light display-6">{{ $post->title }}</h1>
                <div class="d-flex flex-wrap gap-3 text-secondary small">
                    <span>Publicado: {{ optional($post->published_at)->format('d/m/Y H:i') ?? 'Sin fecha' }}</span>
                    @if($post->author)
                        <span>Autor: {{ $post->author->name }}</span>
                    @endif
                </div>
            </header>

            @if($post->cover_image_url)
                <div class="ratio ratio-16x9 rounded-4 overflow-hidden mb-4">
                    <img src="{{ $post->cover_image_url }}" alt="Imagen del art&iacute;culo {{ $post->title }}" class="w-100 h-100 object-fit-cover">
                </div>
            @endif

            <div class="post-content text-secondary lead">
                {!! $post->content !!}
            </div>
        </article>

        @if($related->isNotEmpty())
            <div class="mt-5">
                <h2 class="section-title text-light mb-4">Art&iacute;culos relacionados</h2>
                <div class="row g-4">
                    @foreach($related as $other)
                        <div class="col-md-4">
                            <article class="post-card h-100">
                                <div class="ratio ratio-16x9 overflow-hidden rounded-3 mb-3">
                                    <img src="{{ $other->cover_image_url }}" class="w-100 h-100 object-fit-cover" alt="Imagen de {{ $other->title }}">
                                </div>
                                <span class="badge text-bg-accent mb-2">{{ $other->category }}</span>
                                <h3 class="h6 text-light">{{ $other->title }}</h3>
                                <p class="text-secondary small">{{ \Illuminate\Support\Str::limit(strip_tags($other->excerpt), 100) }}</p>
                                <a href="{{ route('posts.show', $other) }}" class="btn btn-sm btn-outline-light">Leer art&iacute;culo</a>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
