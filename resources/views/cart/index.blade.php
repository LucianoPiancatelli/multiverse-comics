@extends('layouts.app')

@section('title', 'Tu carrito | Multiverse Comics')

@section('content')
    <section class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <p class="text-uppercase text-accent small fw-semibold mb-1">Tu selección</p>
                <h1 class="h2 text-light mb-0">Carrito de compras</h1>
            </div>
            <a href="{{ route('comics.index') }}" class="btn btn-outline-light">Seguir explorando</a>
        </div>

        @if($items->isEmpty())
            <div class="alert alert-info">
                Aún no agregaste cómics. Visitá la <a href="{{ route('comics.index') }}" class="alert-link">tienda</a> para descubrir nuevas historias.
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="cart-list bg-dark rounded-4 shadow-strong p-4">
                        @foreach($items as $item)
                            <div class="cart-item border-bottom border-secondary-subtle pb-4 mb-4">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-3">
                                        <figure class="comic-cover small shadow-sm" style="background-image: url('{{ $item['comic']->cover_image_url }}');">
                                            <img src="{{ $item['comic']->cover_image_url }}" alt="Portada de {{ $item['comic']->title }}" onerror="this.src='https://via.placeholder.com/300x450?text=Multiverse+Comics'; this.onerror=null;">
                                        </figure>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex justify-content-between gap-3">
                                            <div>
                                                <h2 class="h5 text-light mb-1">{{ $item['comic']->title }}</h2>
                                                <p class="text-secondary small mb-2">{{ \Illuminate\Support\Str::limit($item['comic']->description, 100) }}</p>
                                                <span class="badge text-bg-secondary">{{ strtoupper($item['comic']->universe) }}</span>
                                            </div>
                                            <div class="text-end">
                                                <p class="fw-semibold text-light mb-1">{{ $item['comic']->formatted_price }}</p>
                                                <p class="text-secondary small mb-0">Subtotal: ${{ number_format($item['subtotal'], 2) }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                                            <form action="{{ route('cart.update', $item['comic']) }}" method="post" class="d-flex align-items-center gap-2">
                                                @csrf
                                                @method('patch')
                                                <label class="text-secondary small mb-0" for="quantity-{{ $item['comic']->id }}">Cantidad</label>
                                                <input id="quantity-{{ $item['comic']->id }}" type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['comic']->stock }}" class="form-control form-control-sm bg-dark text-light border-secondary">
                                                <button type="submit" class="btn btn-sm btn-outline-light">Actualizar</button>
                                            </form>
                                            <form action="{{ route('cart.destroy', $item['comic']) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-link text-danger text-decoration-none">Quitar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="order-summary bg-dark rounded-4 shadow-strong p-4">
                        <h2 class="h5 text-light">Resumen de compra</h2>
                        <div class="d-flex justify-content-between text-secondary mb-2">
                            <span>Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-secondary mb-4">
                            <span>Envío</span>
                            <span>Calcularemos en el checkout</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-light fw-semibold">Total estimado</span>
                            <span class="text-accent fw-bold fs-4">${{ number_format($total, 2) }}</span>
                        </div>
                        <button type="button" class="btn btn-lg btn-glow-primary w-100 mb-3" disabled>Finalizar compra (próximamente)</button>
                        <form action="{{ route('cart.clear') }}" method="post" onsubmit="return confirm('¿Seguro que querés vaciar el carrito?');">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-outline-light w-100">Vaciar carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection
