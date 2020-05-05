<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function getMyGalleries()
    {
        $user_auth_check = Auth::guard('api');
        dd($user_auth_check);
    }
}
