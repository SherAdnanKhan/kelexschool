<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use App\Models\Feel;
use App\Models\User;
use Illuminate\Database\QueryException;
use Validator;
use Auth;

class FeelController extends BaseController
{
    public function index()
    {
        $returnData = [];
        $returnData['feels'] = $feels = Feel::all();
        return $this->sendResponse($returnData, 'Feel Data');
        
    }

    public function store(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'feel_id' => 'required',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            $user = User::find($user->id);
            $user->feel_id = $request->feel_id;
            $user->save();

            $returnData['user'] = User::with(['feel', 'avatars'])->find($user->id);

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Feel Updated');
    }
}
