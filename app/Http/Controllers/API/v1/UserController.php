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
}
