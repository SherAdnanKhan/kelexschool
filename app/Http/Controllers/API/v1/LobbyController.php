<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Auth;
use App\Models\Fav;
use App\Models\User;
use App\Models\Post;


class LobbyController extends BaseController
{
    public function index()
    {
        $returnData = [];
        $faved_user_ids= $faved_gallery_ids = [];
        $user = Auth::guard('api')->user();
        $faved_users = Fav::where('faved_by', $user->id)->get(['faved_to']);

        foreach($faved_users as $faved_user) {
            array_push($faved_user_ids, $faved_user->faved_to);
        }
        $all_faved_users = User::with('avatars', 'art.parent')->withCount('posts')->whereIn('id', $faved_user_ids)->get();

        //faved gallery images
        //$user_with_faved_galleries = User::with('avatars', 'art.parent', 'favGalleries.posts.image', 'favGalleries.image')->where('id', $user->id)->get();
        $user_with_faved_galleries = User::with([ 'favGalleries' => function ($query)
                                    {
                                        return $query->orderBy('updated_at','DESC');
                                    },
                                    'favGalleries.posts' => function ($query)
                                    {
                                        return $query->orderBy('created_at','DESC');
                                    },
                                    'favGalleries.posts.image',
                                    'favGalleries.image',
                                    'favGalleries.posts.strokeUsers', 
                                    'favGalleries.posts.has_stroke', 
                                    'favGalleries.posts.comments', 
                                    'favGalleries.posts.user.avatars', 
                                    'favGalleries.posts.user.art.parent' ])
                                    //->withCount(['favGalleries.posts.has_stroke'])
                                    ->find($user->id);
        $user_faved_galleries = User::with(['favGalleries'])->find($user->id);
        foreach($user_faved_galleries->favGalleries as $faved_gallery){
            array_push($faved_gallery_ids, $faved_gallery->id);
        }
        $faved_galleries_posts = Post::with(['image', 'user.avatars', 'strokeUsers', 'has_stroke', 'comments', 'user.art.parent', 'gallery'])->whereIn('gallery_id', $faved_gallery_ids)->orderBy('created_at','DESC')->get();
                                
        //$faved_galleries_posts = 
        $user_unread_msg = User::withCount('unreadMessages')->find($user->id);
        $returnData['all_faved_users'] = $all_faved_users;
        $returnData['user_with_faved_galleries'] = $user_with_faved_galleries;
        $returnData['user_with_count_unread'] = $user_unread_msg->unread_messages_count;
        $returnData['faved_galleries_posts'] = $faved_galleries_posts; 
        
        return $this->sendResponse($returnData, 'Lobby Data');
    }
}
