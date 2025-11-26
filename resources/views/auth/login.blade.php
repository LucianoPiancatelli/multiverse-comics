@extends('layouts.app')

@section('title', 'Iniciar sesión - Multiverse')

@section('content')
<div class="container" style="max-width: 720px;">
    <div class="post-card shadow-strong">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="section-title mb-0 text-uppercase text-accent">Iniciar sesión</h1>
            <a class="btn btn-outline-light btn-sm" href="{{ route('register') }}">Crear cuenta</a>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="row g-3">
            @csrf

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
                    autofocus
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="password" class="form-label">Contraseña</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required
                    autocomplete="current-password"
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 d-flex align-items-center gap-2">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                <label for="remember" class="form-check-label">Mantener sesión iniciada</label>
            </div>

            <div class="col-12 mt-2">
                <button class="btn btn-glow-primary w-100 py-2" type="submit">Entrar</button>
            </div>
        </form>
    </div>
</div>
@endsection
