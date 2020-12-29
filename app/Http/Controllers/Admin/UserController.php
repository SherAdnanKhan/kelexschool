<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Admin\BaseController;

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
        $page = $request->input('pagination') ? $request->input('pagination')['page'] :1;
        if ($page) {
            $skip = 10 * ($page - 1);
            $data = User::with('avatar')->withCount('posts', 'galleries')->take(10)->skip($skip)->get();
        } else {
            $data = User::with('avatar')->withCount('posts', 'galleries')->take(10)->skip(0)->get();
        }
        $user_count = User::count();
        $meta = array('page'=>$page,'pages'=>$page,'perpage'=>10,'total'=>$user_count);

        return response(array('meta'=>$meta,'data'=>$data), Response::HTTP_OK);
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
