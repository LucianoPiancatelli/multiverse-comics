@extends('layouts.app')

@section('title', 'Crear cuenta - Multiverse')

@section('content')
<div class="container" style="max-width: 820px;">
    <div class="post-card shadow-strong">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="section-title mb-0 text-uppercase text-accent">Crear cuenta</h1>
            <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">Ya tengo cuenta</a>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="row g-3">
            @csrf

            <div class="col-12">
                <label for="name" class="form-label">Nombre completo</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror"
                    required
                    autocomplete="name"
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="email" class="form-label">Correo</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    required
                    autocomplete="email"
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">Contraseña</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required
                    autocomplete="new-password"
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="form-control"
                    required
                    autocomplete="new-password"
                >
            </div>

            <div class="col-12 mt-2">
                <button class="btn btn-glow-primary w-100 py-2" type="submit">Registrarme</button>
            </div>
        </form>
    </div>
</div>
@endsection
