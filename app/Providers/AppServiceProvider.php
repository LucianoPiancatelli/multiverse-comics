<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator; // <--- ASEGÚRATE DE AGREGAR ESTA LÍNEA

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void // <--- AGREGA EL PARAMETRO AQUÍ
    {
        if (config('app.env') === 'production') {
            $url->forceScheme('https');
        }
    }
}
