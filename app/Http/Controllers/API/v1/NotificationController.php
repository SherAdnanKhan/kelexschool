<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\Notification;

class NotificationController extends BaseController
{
    public function index(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $returnData['notifications'] = Notification::with('notifyable', 'sender.feel', 'sender.avatars')->where('receiver_id', $user->id)->orderBy('created_at', 'DESC')->paginate(env('PAGINATE_LENGTH', 15));
        
        return $this->sendResponse($returnData, 'All notifications');
    }

    public function count()
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $returnData['notification_count'] = Notification::where('receiver_id', $user->id)->count();
        
        return $this->sendResponse($returnData, 'Notifications count');
    }
}
