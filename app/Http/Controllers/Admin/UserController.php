<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends BaseController
{
    public function index()
    {
        $data = [];
        $data['users_count'] = User::count();
        return view('admin.users.index', $data);
    }

    public function getUserData(Request $request)
    {
        $data = [];
        $user_count = User::count();
        $data = User::with('avatar')->withCount('posts', 'galleries')->paginate(10);

        return response()->json($data);
    }

    public function show($slug)
    {
        $data = [];
        $user = User::with('avatar', 'feel', 'galleries.image', 'galleries.privacy', 'galleries.posts.image' ,'art.parent')->withCount('posts', 'galleries', 'comments', 'feeds')->where('slug', $slug)->first();
        if (!isset($user)) {
            return $this->sendError('Invalid User', ['error'=>'No User Exists', 'message' => 'No user exists']);
        }
        $data['user'] = $user;
        return view('admin.users.view', $data);
    }
}
