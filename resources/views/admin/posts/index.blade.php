@extends('layouts.app')

@section('title', 'Entradas - Admin')

@section('content')
<div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <p class="text-secondary mb-1">Administración</p>
            <h1 class="section-title mb-0 text-uppercase text-accent">Blog / Noticias</h1>
        </div>
        <a class="btn btn-glow-primary" href="{{ route('admin.posts.create') }}">Nueva entrada</a>
    </div>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por título, categoría o resumen">
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-outline-light" type="submit">Filtrar</button>
        </div>
    </form>

    <div class="post-card">
        <div class="table-responsive">
            <table class="table table-dark align-middle mb-0">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Autor</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td class="fw-semibold">{{ $post->title }}</td>
                            <td>{{ $post->category }}</td>
                            <td>
                                @if($post->published_at)
                                    <span class="badge bg-success">Publicado</span>
                                @else
                                    <span class="badge bg-warning text-dark">Borrador</span>
                                @endif
                            </td>
                            <td>{{ optional($post->author)->name ?? 'Sin autor' }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-info" target="_blank">Ver</a>
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-light">Editar</a>
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('¿Eliminar esta entrada?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-secondary">No hay entradas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
