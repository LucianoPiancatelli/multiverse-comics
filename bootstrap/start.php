<?php

/**
 * Bootstrap migration runner.
 *
 * This script is executed during application startup to ensure the database
 * schema is up to date before the web server begins handling requests.
 * It runs `php artisan migrate --force` and exits with a non-zero status
 * code if migrations fail, preventing a broken deployment from going live.
 */

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo '[bootstrap/start.php] Running database migrations...' . PHP_EOL;

$status = $kernel->call('migrate', ['--force' => true]);

if ($status !== 0) {
    echo '[bootstrap/start.php] ERROR: Migrations failed with exit code ' . $status . PHP_EOL;
    exit($status);
}

echo '[bootstrap/start.php] Migrations completed successfully.' . PHP_EOL;
