<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Auth;
use App\Models\Fav;
use App\Models\User;
use App\Models\Post;
use App\Models\MessageLog;


class LobbyController extends BaseController
{
    public function posts(Request $request)
    {
        $returnData = [];
        $faved_gallery_ids = [];
        $user = Auth::guard('api')->user();
        //user faved galleries
        $user_faved_galleries = User::with(['favGalleries', 'galleries'])->find($user->id);
        foreach($user_faved_galleries->favGalleries as $faved_gallery){
            if (!in_array($faved_gallery->id, $faved_gallery_ids)) {
                array_push($faved_gallery_ids, $faved_gallery->id);
            }
        }
        //user galleries added too
        foreach($user_faved_galleries->galleries as $gallery){
            if (!in_array($gallery->id, $faved_gallery_ids)) {
                array_push($faved_gallery_ids, $gallery->id);
            }
        }

        $faved_galleries_posts = Post::with(['image', 'user.avatars', 'user.feel', 'strokeUsers', 'has_stroke', 'comments', 'user.art.parent', 'gallery'])->withCount('strokeUsers', 'comments', 'is_vault', 'has_stroke')->whereIn('gallery_id', $faved_gallery_ids)->orderBy('created_at','DESC')->paginate(env('PAGINATE_LENGTH', 15));
        //$user_unread_msg = User::withCount('unreadMessages')->find($user->id);
        
        //$returnData['user_with_count_unread'] = $user_unread_msg->unread_messages_count;
        $returnData['faved_galleries_posts'] = $faved_galleries_posts; 
        
        return $this->sendResponse($returnData, 'Lobby Post Data');
    }

    public function allfavedUsersIds($user_id)
    {
        $faved_user_ids = [];
        $faved_users = Fav::where('faved_by', $user_id)->get(['faved_to']);
        
        foreach($faved_users as $faved_user) {
            array_push($faved_user_ids, $faved_user->faved_to);
        }

        return $faved_user_ids;
    }


    public function allfavedUsers(Request $request) {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $faved_user_ids = $this->allfavedUsersIds($user->id);
        $all_faved_users = User::with('avatars', 'feel', 'art.parent')->withCount('posts')->whereIn('id', $faved_user_ids)->paginate(env('PAGINATE_LENGTH', 15));
        $returnData['all_faved_users'] = $all_faved_users;

        return $this->sendResponse($returnData, 'Lobby Faved Users Data');
    }

    public function unreadMessageConversations()
    {
        $user = Auth::guard('api')->user();
        $conversation_ids = [];
        $message_logs = MessageLog::where([['user_id', $user->id], ['status', 0]])->select('conversation_id')->get();
        //return $message_logs;
        foreach($message_logs as $message_log) {
            if(!in_array($message_log->conversation_id, $conversation_ids)) {
                array_push($conversation_ids, $message_log->conversation_id);
            }
        }

        $conversation_ids = array_unique($conversation_ids);
        return $conversation_ids;
    }


}
