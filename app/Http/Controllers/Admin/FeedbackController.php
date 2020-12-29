<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{

    public function index()
    {
        $data = [];
        $data['feedback_count'] = Feedback::count();
        return view('admin.feedbacks.index', $data);
    }

    public function getFeedbackData(Request $request)
    {
        $data = [];
        $page = $request->input('pagination') ? $request->input('pagination')['page'] :1;
        $skip = 10 * ($page - 1);
        $data = Feedback::with('image' ,'user.avatar')->take(10)->skip($skip)->get();
        $feedback_count = Feedback::count();
        $meta = array('page'=>$page,'pages'=>$page,'perpage'=>10,'total'=>$feedback_count);

        return response(array('meta'=>$meta,'data'=>$data), Response::HTTP_OK);
    }

    public function show($feedbackId)
    {
        $data = [];
        $user = Feedback::with('image', 'user.avatar')->where('id',$feedbackId)->first();
        if (!isset($user)) {
            return $this->sendError('Invalid User', ['error'=>'No User Exists', 'message' => 'No user exists']);
        }
        $data['feedbacks'] = $user;
        return view('admin.feedbacks.view', $data);
    }
}
