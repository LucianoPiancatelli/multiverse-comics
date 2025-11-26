@extends('layouts.app')

@section('title', 'Usuarios - Admin')

@section('content')
<div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <p class="text-secondary mb-1">Administración</p>
            <h1 class="section-title mb-0 text-uppercase text-accent">Usuarios</h1>
        </div>
    </div>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por nombre, correo o rol">
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-outline-light" type="submit">Filtrar</button>
        </div>
    </form>

    <div class="row g-3">
        @forelse($users as $user)
            <div class="col-md-4">
                <div class="post-card h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="h5 mb-1">{{ $user->name }}</h2>
                            <p class="mb-1 text-secondary">{{ $user->email }}</p>
                            <span class="badge bg-secondary text-uppercase">{{ $user->role }}</span>
                        </div>
                        <a class="btn btn-outline-info btn-sm" href="{{ route('admin.users.show', $user) }}">Detalle</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-secondary">No hay usuarios registrados.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>
@endsection
