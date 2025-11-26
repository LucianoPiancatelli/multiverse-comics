<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $featuredComics = Comic::featured()->orderByDesc('release_date')->take(3)->get();
        $newReleases = Comic::orderByDesc('release_date')->take(4)->get();
        $latestPosts = Post::orderByDesc('published_at')->take(3)->get();

        $heroComic = $featuredComics->first() ?? $newReleases->first();

        return view('home', [
            'heroComic' => $heroComic,
            'featuredComics' => $featuredComics,
            'newReleases' => $newReleases,
            'latestPosts' => $latestPosts,
        ]);
    }
}
