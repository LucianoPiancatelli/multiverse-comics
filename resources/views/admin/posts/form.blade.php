@extends('layouts.app')

@section('title', $mode === 'edit' ? 'Editar entrada' : 'Nueva entrada')

@section('content')
<div class="container" style="max-width: 960px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <p class="text-secondary mb-1">Administración</p>
            <h1 class="section-title mb-0 text-uppercase text-accent">
                {{ $mode === 'edit' ? 'Editar entrada' : 'Nueva entrada' }}
            </h1>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-light btn-sm">Volver</a>
    </div>

    <div class="post-card">
        <form method="POST" action="{{ $mode === 'edit' ? route('admin.posts.update', $post) : route('admin.posts.store') }}" enctype="multipart/form-data" class="row g-3">
            @csrf
            @if($mode === 'edit')
                @method('PUT')
            @endif

            <div class="col-12">
                <label for="title" class="form-label">Título</label>
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="category" class="form-label">Categoría</label>
                <input type="text" id="category" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $post->category) }}" required>
                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="published_at" class="form-label">Fecha de publicación</label>
                <input type="datetime-local" id="published_at" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\\TH:i')) }}">
                @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label for="cover_image" class="form-label">Portada (opcional)</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror" accept="image/*">
                @error('cover_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @if($post->cover_image)
                    <div class="mt-2">
                        <small class="text-secondary d-block mb-1">Portada actual:</small>
                        <img src="{{ $post->cover_image_url }}" alt="Portada" class="img-fluid rounded" style="max-height: 220px;">
                    </div>
                @endif
            </div>

            <div class="col-12">
                <label for="excerpt" class="form-label">Resumen</label>
                <textarea id="excerpt" name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3" required>{{ old('excerpt', $post->excerpt) }}</textarea>
                @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label for="content" class="form-label">Contenido</label>
                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="8" required>{{ old('content', $post->content) }}</textarea>
                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12 form-check">
                <input class="form-check-input" type="checkbox" value="1" id="is_featured" name="is_featured" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">
                    Destacar en la portada
                </label>
            </div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-glow-primary">
                    {{ $mode === 'edit' ? 'Guardar cambios' : 'Crear entrada' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
