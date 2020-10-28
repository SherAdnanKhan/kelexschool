<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Storage;
use App\Models\UserSprvfsIO;
use App\Models\UserPrivacy;
use App\Models\Fav;
use App\Models\UserLog;
use App\Models\UserBlock;

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
        $user_page_privacy = UserPrivacy::where([ ['user_id', $user_id], ['privacy_type', 'App\Models\PrivacyPage'], ['privacy_id', 3] ])->first();

        if(!isset($user_page_privacy)) {
            $other_privacy = [
                'privacy_page' => "Critiques",
                'is_allowed' => 1
            ];
        }else {
            if ($user_page_privacy->privacy_type_id == 1) {
                $other_privacy = [
                    'privacy_page' => "Critiques",
                    'is_allowed' => 1
                ];
            }
            else if ($user_page_privacy->privacy_type_id == 2) {
                $check_fav = Fav::where([ ['faved_by', $user_id], ['faved_to', $my_user_id] ])->first();
                if (isset($check_fav)) {
                   $other_privacy = [
                        'privacy_page' => "Critiques",
                        'is_allowed' => 1
                    ];
                }
                else {
                   $other_privacy = [
                        'privacy_page' => "Critiques",
                        'is_allowed' => 0
                    ];
                }
            }
            else if ($user_page_privacy->privacy_type_id == 3) {
                if ($is_sprfvs == 1) {
                   $other_privacy = [
                        'privacy_page' => "Critiques",
                        'is_allowed' => 1
                    ];
                }else {
                   $other_privacy = [
                        'privacy_page' => "Critiques",
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
                        'privacy_page' => "Critiques",
                        'is_allowed' => 1
                        ];
                    }
                    else {
                       $other_privacy = [
                            'privacy_page' => "Critiques",
                            'is_allowed' => 0
                        ];
                    }
            }
            else {
               $other_privacy = [
                    'privacy_page' => "Critiques",
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
}
