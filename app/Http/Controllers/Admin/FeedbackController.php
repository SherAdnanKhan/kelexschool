<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\Request;
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
        $data = Feedback::with('image' ,'user.avatar')->get();

        return response()->json($data);
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
