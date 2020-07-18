<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [];
        $data['user_count'] = $count_of_users = User::count();
        $data['post_count'] = $count_of_posts = Post::count();
        return view('admin.dashboard', $data);
    }
}
