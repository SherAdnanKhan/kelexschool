<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Storage;

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
}
