<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Auth;
use App\Models\Fav;
use App\Models\User;


class LobbyController extends BaseController
{
    public function index()
    {
        $returnData = [];
        $faved_user_ids = [];
        $user = Auth::guard('api')->user();
        $faved_users = Fav::where('faved_by', $user->id)->get(['faved_to']);
        foreach($faved_users as $faved_user) {
            array_push($faved_user_ids, $faved_user->faved_to);
        }
        $all_faved_users = User::with('avatars')->whereIn('id', $faved_user_ids)->get();
        return $this->sendResponse($all_faved_users, '');
    }
}