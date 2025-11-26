<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        $query = User::query()->orderByDesc('created_at');

        if ($request->filled('search')) {
            $search = '%' . $request->get('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                    ->orWhere('email', 'like', $search)
                    ->orWhere('role', 'like', $search);
            });
        }

        $users = $query->paginate(12)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): \Illuminate\View\View
    {
        $recentPosts = $user->posts()->latest()->take(5)->get();

        return view('admin.users.show', [
            'user' => $user,
            'recentPosts' => $recentPosts,
        ]);
    }
}
