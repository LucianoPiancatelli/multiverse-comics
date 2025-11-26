<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@multiverse-comics.com'],
            [
                'name' => 'Multiverse Admin',
                'password' => Hash::make('multiverse123'),
                'role' => 'admin',
            ],
        );

        User::firstOrCreate(
            ['email' => 'fan@multiverse-comics.com'],
            [
                'name' => 'Comic Fan',
                'password' => Hash::make('fan12345'),
                'role' => 'user',
            ],
        );

        $this->call([
            ComicSeeder::class,
            PostSeeder::class,
        ]);
    }
}
