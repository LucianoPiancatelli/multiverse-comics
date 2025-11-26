<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function __invoke(): \Illuminate\View\View
    {
        $stats = [
            'users' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'posts' => Post::count(),
            'comics' => Comic::count(),
        ];

        $latestUsers = User::latest()->take(5)->get();
        $latestPosts = Post::latest()->take(5)->get();

        $topCategories = Post::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestUsers', 'latestPosts', 'topCategories'));
    }
}
