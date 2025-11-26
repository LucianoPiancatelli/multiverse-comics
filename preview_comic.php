<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$comic = App\Models\Comic::first();

$view = view('comics.show', ['comic' => $comic, 'related' => collect()])->render();

echo $view;
