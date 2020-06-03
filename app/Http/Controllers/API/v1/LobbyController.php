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
        $all_faved_users = User::with('avatars', 'art.parent')->withCount('posts')->whereIn('id', $faved_user_ids)->get();

        //faved gallery images
        //$user_with_faved_galleries = User::with('avatars', 'art.parent', 'favGalleries.posts.image', 'favGalleries.image')->where('id', $user->id)->get();
        $user_with_faved_galleries = $user->load('favGalleries.posts.image', 'favGalleries.image', 'favGalleries.posts.user.avatars', 'favGalleries.posts.user.art.parent', 'unreadMessages');
        $user_unread_msg = User::withCount('unreadMessages')->find($user->id);
        $returnData['all_faved_users'] = $all_faved_users;
        $returnData['user_with_faved_galleries'] = $user_with_faved_galleries;
        //$returnData['user_with_count_unread'] = $user_unread_msg;

        return $this->sendResponse($returnData, '');
    }
}
