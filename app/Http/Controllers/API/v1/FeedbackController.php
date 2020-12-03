<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\Feedback;
use App\Models\Image;

class FeedbackController extends BaseController
{
    public function store(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'feedback' => 'required|min:3',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {

            $feedback = new Feedback();
            $feedback->feedback = $request->feedback;
            $feedback->created_by = $user->id;
            $feedback->save();

            if($request->has('image_path') && $request->has('image_name')) {
                $image = new Image();
                $image->title = $request->image_name;
                $image->path = $request->image_path;
                $image->image_type = 'App\Models\Feedback';
                $image->image_id = $feedback->id;
                $image->created_by = $user->id;
                $image->save();
            }
            //updated feed
            $returnData['feedback'] = Feedback::with('image')->find($feedback->id);

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Chat Message sent');
    }
}
