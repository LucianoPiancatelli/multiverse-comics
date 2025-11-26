<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    public function index(Request $request)
    {
        $query = Comic::query();

        if ($request->filled('universe') && in_array($request->get('universe'), ['dc', 'marvel'], true)) {
            $query->where('universe', $request->get('universe'));
        }

        if ($request->filled('search')) {
            $query->where(function ($innerQuery) use ($request) {
                $search = '%' . $request->get('search') . '%';
                $innerQuery
                    ->where('title', 'like', $search)
                    ->orWhere('series', 'like', $search)
                    ->orWhere('description', 'like', $search);
            });
        }

        $sort = $request->get('sort');

        $sortedQuery = match ($sort) {
            'release' => $query->orderByDesc('release_date'),
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            default => $query->orderBy('title'),
        };

        $comics = $sortedQuery->paginate(9)->withQueryString();

        return view('comics.index', [
            'comics' => $comics,
            'filters' => $request->only(['universe', 'search']),
        ]);
    }

    public function show(Comic $comic)
    {
        $related = Comic::where('universe', $comic->universe)
            ->where('id', '!=', $comic->getKey())
            ->take(4)
            ->get();

        return view('comics.show', [
            'comic' => $comic,
            'related' => $related,
        ]);
    }
}
