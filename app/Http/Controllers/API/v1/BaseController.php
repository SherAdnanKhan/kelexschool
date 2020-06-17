<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Storage;
use App\Models\UserSprvfsIO;
use App\Models\UserPrivacy;

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
}
