@extends('layouts.app')

@section('title', 'Perfil de usuario')

@section('content')
<div class="container" style="max-width: 960px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <p class="text-secondary mb-1">Usuarios</p>
            <h1 class="section-title mb-0 text-uppercase text-accent">{{ $user->name }}</h1>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light btn-sm">Volver</a>
    </div>

    <div class="post-card mb-3">
        <dl class="row mb-0">
            <dt class="col-sm-4">Nombre</dt>
            <dd class="col-sm-8">{{ $user->name }}</dd>

            <dt class="col-sm-4">Correo</dt>
            <dd class="col-sm-8">{{ $user->email }}</dd>

            <dt class="col-sm-4">Rol</dt>
            <dd class="col-sm-8"><span class="badge bg-secondary text-uppercase">{{ $user->role }}</span></dd>

            <dt class="col-sm-4">Alta</dt>
            <dd class="col-sm-8">{{ $user->created_at?->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>

    <div class="post-card">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="h5 mb-0 text-accent">Entradas recientes</h2>
            <span class="text-secondary small">máx. 5</span>
        </div>
        <ul class="list-group list-group-flush">
            @forelse($recentPosts as $post)
                <li class="list-group-item bg-transparent text-light d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $post->title }}</strong>
                        <div class="small text-secondary">{{ $post->category }}</div>
                    </div>
                    <a class="btn btn-outline-info btn-sm" target="_blank" href="{{ route('posts.show', $post) }}">Ver</a>
                </li>
            @empty
                <li class="list-group-item bg-transparent text-secondary">No tiene entradas asignadas.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
