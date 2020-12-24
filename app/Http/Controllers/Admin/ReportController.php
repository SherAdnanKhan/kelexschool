<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\UserReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        $data = [];
        $data['report_count'] = UserReport::count();
        return view('admin.reports.user.index', $data);
    }

    public function getReportUserData(Request $request)
    {
        $data = [];
        $data = UserReport::with('reportToUser.avatars','reportByUser.avatars')->get();
        return response()->json($data);
    }

    public function banUser($slug,$report_id)
    {
        $data = [];
        $user = User::where('slug', $slug)->first();
        $report = UserReport::find($report_id);
        if (!isset($user)) {
            return $this->sendError('Invalid User', ['error'=>'No User Exists', 'message' => 'No user exists']);
        }
        if (!isset($report)) {
            return $this->sendError('Invalid Report ID', ['error'=>'No Report Exists', 'message' => 'No Report exists']);
        }
        $user->status='0';
        $user->update();
        $report->delete();
        return redirect('admin/reports');
    }

    public function deleteReport($report_id)
    {
        $data = [];
        $report = UserReport::find($report_id);
        if (!isset($report)) {
            return $this->sendError('Invalid Report ID', ['error'=>'No Report Exists', 'message' => 'No Report exists']);
        }
        $report->delete();
        return redirect('admin/reports');
    }

    public function indexPost()
    {
        $data = [];
        $data['report_count'] = Post::where('reports','1')->count();
        return view('admin.reports.post.index', $data);
    }

    public function getReportPostData(Request $request)
    {
        $data = [];
        $data = Post::with('image','user.avatars')->where('reports','1')->get();
        return response()->json($data);
    }

    public function viewPost($slug)
    {
        $data = [];
        $data = Post::with('image','user.avatars')->where('slug',$slug)->first();
        $data['post'] = $data;
        return view('admin.reports.post.view', $data);
    }

    public function removePost($slug)
    {
        $currentPost = Post::where('slug',$slug)->first();
        if (!isset($currentPost)) {
            return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No Post exists']);
        }
        if($currentPost->parent_id==null) {
            $currentPost->delete();
        }
        else {
            $parentPost = Post::where('id',$currentPost->parent_id)->delete();
            if (!isset($parentPost)) {
                return $this->sendError('Invalid Parent', ['error'=>'No Post Exists', 'message' => 'Post Already Delete']);
            }
        }
        return redirect('admin/post-reports');
    }

    public function deletePostReport($slug)
    {
        $data = [];
        $currentPost = Post::where('slug',$slug)->first();
        if (!isset($currentPost)) {
            return $this->sendError('Invalid Post ID', ['error'=>'No Post Exists', 'message' => 'No Post exists']);
        }
        $currentPost->reports='0';
        $currentPost->update();

        return redirect('admin/post-reports');
    }
}
