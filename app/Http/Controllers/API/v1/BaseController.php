<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Storage;
use App\Models\UserSprvfsIO;
use App\Models\PrivacyPage;
use App\Models\UserPrivacy;
use App\Models\Fav;
use App\Models\UserLog;
use App\Models\UserBlock;
use App\Models\UserMute;
use App\Models\UserConversation;
use Validator;
use Auth;

class BaseController extends Controller
{
    use ValidatesRequests;
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)){
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function uploadImage($file, $directory)
    {
        $returnData=[];
        $fileNameStore = time();
        $extention = $file->getClientOriginalExtension();
        $uuid = $this->generateRandomString();
        $imageName = $uuid.'-'.$fileNameStore.'.'.$extention;
        $image = $file;

        Storage::disk('s3')->put($directory.$imageName, file_get_contents($image), 'public');
        $image_path = Storage::disk('s3')->url($directory.$imageName);
        $returnData = ['image_path' => $image_path, 'image_name' => $imageName];
        return $returnData;
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function CheckPrivacyPage($is_sprfvs, $my_user_id, $user_id, $page_id)
    {
        $other_privacy = [];
        $privacy_page = PrivacyPage::findOrFail($page_id);
        //dd($privacy_page);
        $user_page_privacy = UserPrivacy::where([ ['user_id', $user_id], ['privacy_type', 'App\Models\PrivacyPage'], ['privacy_id', 3] ])->first();

        if(!isset($user_page_privacy)) {
            $other_privacy = [
                'privacy_page' => $privacy_page->name,
                'is_allowed' => 1
            ];
        }else {
            if ($user_page_privacy->privacy_type_id == 1) {
                $other_privacy = [
                    'privacy_page' => $privacy_page->name,
                    'is_allowed' => 1
                ];
            }
            else if ($user_page_privacy->privacy_type_id == 2) {
                $check_fav = Fav::where([ ['faved_by', $user_id], ['faved_to', $my_user_id] ])->first();
                if (isset($check_fav)) {
                   $other_privacy = [
                        'privacy_page' => $privacy_page->name,
                        'is_allowed' => 1
                    ];
                }
                else {
                   $other_privacy = [
                        'privacy_page' => $privacy_page->name,
                        'is_allowed' => 0
                    ];
                }
            }
            else if ($user_page_privacy->privacy_type_id == 3) {
                if ($is_sprfvs == 1) {
                   $other_privacy = [
                        'privacy_page' => $privacy_page->name,
                        'is_allowed' => 1
                    ];
                }else {
                   $other_privacy = [
                        'privacy_page' => $privacy_page->name,
                        'is_allowed' => 0
                    ];
                }
                    
            }
            else if ($user_page_privacy->privacy_type_id == 4) {
                $user_srfvs = UserSprvfsIO::where([
                    ['created_to',  $my_user_id], 
                    ['privacy_type_id', $user_page_privacy->privacy_type_id], 
                    ['created_by', $user_id],
                    ])->first();
                    if (isset($user_srfvs)) {
                       $other_privacy = [
                        'privacy_page' => $privacy_page->name,
                        'is_allowed' => 1
                        ];
                    }
                    else {
                       $other_privacy = [
                            'privacy_page' => $privacy_page->name,
                            'is_allowed' => 0
                        ];
                    }
            }
            else {
               $other_privacy = [
                    'privacy_page' => $privacy_page->name,
                    'is_allowed' => 0
                ];
            }
            
        }

        return $other_privacy;
    }

    public function UserFavesIds($user_id)
    {
        $faved_user_ids = [];
        $favs = Fav::where('faved_by', $user_id)->get(['faved_to']);
        foreach($favs as $fav) {
            array_push($faved_user_ids, $fav->faved_to);
        }
        return $faved_user_ids;
    }

    public function UserSprfvsIds($user_id)
    {
        $user_list_ids = [];
        $user_lists = UserSprvfsIO::where([
            ['status',  1], 
            ['privacy_type_id', 3],
            ['created_to', $user_id] 
            ])->get(); 
        foreach($user_lists as $user_list) {
            array_push($user_list_ids, $user_list->created_by);
        }
        return $user_list_ids;
    }

    public function UserSprfvsFavsIds($user_id)
    {
        $user_list_ids = [];
        $favs = Fav::where('faved_by', $user_id)->get(['faved_to']);
        foreach($favs as $fav) {
            array_push($user_list_ids, $fav->faved_to);
        }
        $user_lists = UserSprvfsIO::where([
            ['status',  1], 
            ['privacy_type_id', 3],
            ['created_to', $user_id] 
            ])->get(); 
        foreach($user_lists as $user_list) {
            array_push($user_list_ids, $user_list->created_by);
        }
        return $user_list_ids;
    }

    public function NotificationStore($activity_type, $activity_id, $description, $user_id)
    {
        $user_log = new UserLog();
        $user_log->activity_type = $activity_type;
        $user_log->activity_id = $activity_id;
        $user_log->description = $description;
        $user_log->user_id = $user_id;
        $user_log->save();

        return;

    }

    public function CheckUserBlocked($auth_user_id, $check_user_id)
    {
        $is_blocked = false;
        $block_user_check = UserBlock::where([
        ['block_to', $check_user_id], 
        ['block_by', $auth_user_id]
        ])->first();
        if(isset($block_user_check)) {
            $is_blocked = true;
        }
        return $is_blocked;
    }

    public function CheckUserMute($auth_user_id, $check_user_id)
    {
        $is_muted = false;
        $mute_user_check = UserMute::where([
        ['mute_to', $check_user_id], 
        ['mute_by', $auth_user_id]
        ])->first();
        if(isset($mute_user_check)) {
            $is_muted = true;
        }
        return $is_muted;
    }

    public function CheckUserViewable($auth_user_id, $check_user_id)
    {
        $is_viewable = true;
        $block_user_check = UserBlock::where([
        ['block_to', $check_user_id], 
        ['block_by', $auth_user_id]
        ])->first();
        if(isset($block_user_check)) {
            $is_viewable = false;
        }
        $block_user_check = UserBlock::where([
            ['block_to', $auth_user_id], 
            ['block_by', $check_user_id]
            ])->first();
        if(isset($block_user_check)) {
            $is_viewable = false;
        }

        return $is_viewable;
    }

    public function getDeletedConversationIds($user_id)
    {
        $deleted_conversation_ids = [];
        $deleted_conversations = UserConversation::where([ ['is_deleted', 1], ['user_id', $user_id] ])->get('conversation_id');
        foreach ($deleted_conversations as $deleted_conversation) {
          array_push($deleted_conversation_ids, $deleted_conversation->conversation_id);
        }

        return $deleted_conversation_ids;
    }

    public function genericUploads(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $file_type = "document";
        $supported_image = ["jpg","jpeg","gif","png","bmp"];
        $supported_video = ["mp4", "m4a", "m4v", "f4v", "f4a", "m4b", "m4r", "f4b", "mov", "3gp", "3gp2", "3g2", "3gpp", "3gpp2", "ogg", "oga", "ogv", "ogx", "wmv", "wma", "asf*", "webm", "flv", "MTS", "mpg", "mkv", "mpeg"];

        $directory = 'generic/uploads/';
        if (!isset($request->file_upload)) {
            return $this->sendError('No file', ['error'=>'No file', 'message' => 'Please send attachement to upload']);
        }
        $validator = Validator::make($request->all(), [
            'file_upload' => env('DOCUMENT_SIZE', '2000'),
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $file = $request->file_upload;
        return $file;
        try {
            $fileNameStore = time();
            $extension = $file->getClientOriginalExtension();
            $uuid = $this->generateRandomString();
            if (!$extension || $extension == '') {
                if($file_type == "image") {
                    $extension = 'jpeg';
                }
            }
            $imageName = $uuid.'-'.$fileNameStore.'.'.$extension;
            $fileName = pathinfo($file)['filename'];
            if(!isset($fileName) || $fileName= ' ') {
                pathinfo($file)['filename'] = $uuid;
            }
            //$file = $_FILES['file_upload'];
            //dd($_FILES['file_upload']);

            if(in_array($extension,$supported_image)) {
                $file_type = "image";
                $directory = 'generic/images/';
            }
            else if (in_array($extension, $supported_video)) {
                $file_type = "video";
                $directory = 'generic/videos/';
            }
            else {
                $file_type = "document";
                $directory = 'generic/uploads/';
            }

            Storage::disk('s3')->put($directory.$imageName,  fopen($file, 'r+'), 'public');
            $document_path = Storage::disk('s3')->url($directory.$imageName);
        
            $returnData['path'] = $document_path;
            $returnData['doc_type'] = $file_type;
            $returnData['doc_name'] = $imageName; 
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        
        return $this->sendResponse($returnData, 'File Uploaded');
    }
    
}
