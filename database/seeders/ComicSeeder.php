<?php

namespace Database\Seeders;

use App\Models\Comic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ComicSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $comics = [
            [
                'title' => 'Batman: Year One',
                'universe' => 'dc',
                'series' => 'Batman',
                'writer' => 'Frank Miller',
                'artist' => 'David Mazzucchelli',
                'description' => 'Un clásico que explora los primeros días de Bruce Wayne como Batman y el origen del Comisionado Gordon en Gotham City.',
                'price' => 15000,
                'stock' => 35,
                'release_date' => '1987-02-01',
                'cover_image' => '/images/comics/batman.jpg',
                'is_featured' => true,
            ],
            [
                'title' => 'Superman: Son of Kal-El',
                'universe' => 'dc',
                'series' => 'Superman',
                'writer' => 'Tom Taylor',
                'artist' => 'John Timms',
                'description' => 'La nueva generación de Superman asume la responsabilidad de proteger a la Tierra mientras busca su identidad.',
                'price' => 13500,
                'stock' => 20,
                'release_date' => '2021-07-13',
                'cover_image' => '/images/comics/superman.webp',
                'is_featured' => false,
            ],
            [
                'title' => 'Spider-Man: Into the Spider-Verse',
                'universe' => 'marvel',
                'series' => 'Spider-Man',
                'writer' => 'Brian Michael Bendis',
                'artist' => 'Sara Pichelli',
                'description' => 'Miles Morales descubre que no está solo como Spider-Man y se encuentra con héroes de todo el multiverso.',
                'price' => 18000,
                'stock' => 28,
                'release_date' => '2018-12-12',
                'cover_image' => '/images/comics/spider.jpg',
                'is_featured' => true,
            ],
            [
                'title' => 'Avengers: Civil War',
                'universe' => 'marvel',
                'series' => 'Avengers',
                'writer' => 'Kurt Busiek',
                'artist' => 'Alan Davis',
                'description' => 'Los Avengers se enfrentan entre ellos por una crisis en el equipo.',
                'price' => 25000,
                'stock' => 18,
                'release_date' => '2001-09-01',
                'cover_image' => '/images/comics/avengers.jpeg',
                'is_featured' => false,
            ],
            [
                'title' => 'Wonder Woman: Historia',
                'universe' => 'dc',
                'series' => 'Wonder Woman',
                'writer' => 'Kelly Sue DeConnick',
                'artist' => 'Phil Jimenez',
                'description' => 'Una reimaginación épica de las Amazonas y la herencia que rodea a Diana Prince.',
                'price' => 24000,
                'stock' => 15,
                'release_date' => '2020-11-24',
                'cover_image' => '/images/comics/wonder.webp',
                'is_featured' => false,
            ],
        ];

        $currentSlugs = collect($comics)
            ->map(fn (array $comic) => Str::slug($comic['title']))
            ->all();

        Comic::whereNotIn('slug', $currentSlugs)->delete();

        foreach ($comics as $comic) {
            Comic::updateOrCreate(
                ['slug' => Str::slug($comic['title'])],
                array_merge(
                    Arr::except($comic, ['title']),
                    [
                        'title' => $comic['title'],
                        'slug' => Str::slug($comic['title']),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                ),
            );
        }
    }
}
