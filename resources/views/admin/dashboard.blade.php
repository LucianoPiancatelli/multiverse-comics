@extends('layouts.app')

@section('title', 'Panel de administración')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="section-title mb-0 text-uppercase text-accent">Panel de administración</h1>
        <a class="btn btn-outline-light btn-sm" href="{{ route('home') }}">Ver sitio</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="feature-card h-100">
                <p class="text-secondary mb-1">Usuarios</p>
                <p class="fs-2 fw-bold mb-0">{{ $stats['users'] }}</p>
                <small class="text-success">{{ $stats['admins'] }} administradores</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="feature-card h-100">
                <p class="text-secondary mb-1">Entradas</p>
                <p class="fs-2 fw-bold mb-0">{{ $stats['posts'] }}</p>
                <small class="text-light">Blog / Noticias</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="feature-card h-100">
                <p class="text-secondary mb-1">Productos</p>
                <p class="fs-2 fw-bold mb-0">{{ $stats['comics'] }}</p>
                <small class="text-light">Cómics activos</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="feature-card h-100">
                <p class="text-secondary mb-1">Categorías top</p>
                <p class="fs-2 fw-bold mb-0">{{ $topCategories->sum('total') }}</p>
                <small class="text-light">Total entradas categorizadas</small>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="post-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="h5 mb-0 text-accent">Últimos usuarios</h2>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light btn-sm">Ver todos</a>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($latestUsers as $user)
                        <li class="list-group-item bg-transparent text-light d-flex justify-content-between">
                            <span>{{ $user->name }}</span>
                            <span class="badge bg-secondary text-uppercase">{{ $user->role }}</span>
                        </li>
                    @empty
                        <li class="list-group-item bg-transparent text-light">Sin usuarios.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="post-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="h5 mb-0 text-accent">Últimas entradas</h2>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-light btn-sm">Gestionar</a>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($latestPosts as $post)
                        <li class="list-group-item bg-transparent text-light">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $post->title }}</strong>
                                    <div class="small text-secondary">{{ $post->category }}</div>
                                </div>
                                <span class="badge bg-info text-dark">{{ optional($post->published_at)->format('d/m/Y') ?? 'Borrador' }}</span>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item bg-transparent text-light">Sin entradas cargadas.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
