<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends BaseController
{
    public function getAllUsers()
    {
        $users = User::all();
        return $this->sendResponse($users, 'all users list');
    }
    
    public function searchUsers(Request $request)
    {
        $returnData = [];
        try {
            if($request->has('name')) {
                $users = User::with(['avatars', 'art', 'postsImagesRandom' => function($query) {
                    return $query->limit(4);
                }])->where('username', 'LIKE', '%'.$request->name.'%')->get();
            }else {
              $users = User::with(['avatars', 'art', 'postsImagesRandom' => function($query) {
                return $query->limit(4);
                }])->all();  
            }
            $returnData['users'] = $users;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);
        }
        return $this->sendResponse($returnData, 'Artist Search result');
    }
}
