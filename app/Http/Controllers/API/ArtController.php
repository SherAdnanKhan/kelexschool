<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtController extends Controller
{
    public function getAll()
    {
        $returnData = [];
        $user_auth_check = Auth::guard('api')->check();
        if (!$user_auth_check) {
            return $this->sendError('Unauthorized', 'Please Login to proceed');
        }

        $arts = Art::with('children')->get();
        dd($arts);
    }
}
