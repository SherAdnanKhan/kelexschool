<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Post;
use App\Models\Feed;
use App\Models\Vault;

class VaultController extends BaseController
{
    public function index(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $returnData['vault_posts'] = $vaults = vault::with('post.image', 'post.user.avatars')->where('user_id', $user->id)->where('vaultable_type', 'App\Models\Post')->paginate(env('PAGINATE_LENGTH', 15));
        //$returnData['vault_feeds'] = $vaults = vault::with('feed.image', 'feed.user.avatars')->where('user_id', $user->id)->where('vaultable_type', 'App\Models\Feed')->get();
        return $this->sendResponse($returnData, 'Fetched Vault list');
    }

    public function store(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'vaultable_id' => 'required',
            'vaultable_type' => 'required', //type 1 for post, type 2 for Feed 
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try{
            if($request->vaultable_type == 1) {
                $post = Post::with('image')->find($request->vaultable_id);
                if (!isset($post)) {
                    return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No post exists']);
                }
                $vault = new vault();
                $vault->vaultable_id = $request->vaultable_id;
                $vault->vaultable_type = 'App\Models\Post';
                $vault->user_id = $user->id;
                $vault->save();
                $returnData['valut'] = $post;
                return $this->sendResponse($returnData, 'Post Added to Vault');

            }
            else if($request->vaultable_type == 2 ) {
                $isFeed = Feed::with('image')->find($request->vaultable_id);
                if(!isset($isFeed)) {
                    return $this->sendError('Invalid Feed', ['error'=>'Unauthorised Feed', 'message' => 'Please add correct feed']);
                }
                $vault = new vault();
                $vault->vaultable_id = $request->vaultable_id;
                $vault->vaultable_type = 'App\Models\Feed';
                $vault->user_id = $user->id;
                $vault->save();
                $returnData['valut'] = $isFeed;
                return $this->sendResponse($returnData, 'Feed Added to Vault');
            }
        }catch(QueryException $ex) {
            return $this->sendError('Query Exception Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Added');
        
    }
}
