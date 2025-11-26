<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('author')->orderByDesc('published_at');

        if ($request->filled('category')) {
            $query->where('category', $request->get('category'));
        }

        if ($request->filled('search')) {
            $search = '%' . $request->get('search') . '%';
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery
                    ->where('title', 'like', $search)
                    ->orWhere('excerpt', 'like', $search)
                    ->orWhere('content', 'like', $search);
            });
        }

        $posts = $query->paginate(6)->withQueryString();

        $categories = Post::select('category')->distinct()->pluck('category');

        return view('posts.index', [
            'posts' => $posts,
            'categories' => $categories,
            'filters' => $request->only(['category', 'search']),
        ]);
    }

    public function show(Post $post)
    {
        $related = Post::where('category', $post->category)
            ->where('id', '!=', $post->getKey())
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('posts.show', [
            'post' => $post,
            'related' => $related,
        ]);
    }
}
