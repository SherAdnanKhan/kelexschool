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
        $data['meta'] = [
          "page"=> 1,
          "pages"=> 1,
          "perpage"=> -1,
          "total"=> $user_count,
          "sort"=> "asc",
          "field"=> "id"
        ];
        $data['data'] = User::with('avatars')->withCount('posts', 'galleries')->get();

        return response()->json($data);
    }

    public function show($slug)
    {
        $data = [];
        $user = User::with('avatars', 'galleries.image', 'galleries.privacy', 'galleries.posts.image' ,'art.parent')->withCount('posts', 'galleries', 'comments', 'feeds')->where('slug', $slug)->first();
        if (!isset($user)) {
            return $this->sendError('Invalid User', ['error'=>'No User Exists', 'message' => 'No user exists']);
        }
        $data['user'] = $user;
        return view('admin.users.view', $data);
    }
}
