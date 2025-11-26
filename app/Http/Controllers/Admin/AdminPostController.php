<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        $query = Post::with('author')->orderByDesc('published_at');

        if ($request->filled('search')) {
            $search = '%' . $request->get('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                    ->orWhere('excerpt', 'like', $search)
                    ->orWhere('category', 'like', $search);
            });
        }

        $posts = $query->paginate(10)->withQueryString();

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): \Illuminate\View\View
    {
        return view('admin.posts.form', [
            'post' => new Post(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = $request->user()->getKey();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->storeImage($request->file('cover_image'));
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('status', 'Entrada creada correctamente.');
    }

    public function edit(Post $post): \Illuminate\View\View
    {
        return view('admin.posts.form', [
            'post' => $post,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Post $post): \Illuminate\Http\RedirectResponse
    {
        $data = $this->validateData($request, $post->getKey());
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('cover_image')) {
            if ($post->cover_image && str_starts_with($post->cover_image, 'storage/')) {
                Storage::delete(str_replace('storage/', 'public/', $post->cover_image));
            }
            $data['cover_image'] = $this->storeImage($request->file('cover_image'));
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('status', 'Entrada actualizada.');
    }

    public function destroy(Post $post): \Illuminate\Http\RedirectResponse
    {
        if ($post->cover_image && str_starts_with($post->cover_image, 'storage/')) {
            Storage::delete(str_replace('storage/', 'public/', $post->cover_image));
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'Entrada eliminada.');
    }

    protected function validateData(Request $request, ?int $postId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:80'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'excerpt' => ['required', 'string', 'max:600'],
            'content' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
            'is_featured' => ['sometimes', 'boolean'],
            'slug' => [
                'nullable',
                Rule::unique('posts', 'slug')->ignore($postId),
            ],
        ], [
            'cover_image.image' => 'La portada debe ser una imagen.',
        ]);
    }

    protected function storeImage(\Illuminate\Http\UploadedFile $file): string
    {
        $path = $file->store('public/posts');

        return str_replace('public/', 'storage/', $path);
    }
}
