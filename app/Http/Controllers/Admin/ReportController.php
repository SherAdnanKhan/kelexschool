<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\UserReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $page = $request->input('pagination') ? $request->input('pagination')['page'] :1;
        $skip = 10 * ($page - 1);
        $data = UserReport::with('reportToUser.avatar','reportByUser.avatar')->take(10)->skip($skip)->get();
        $user_report_count = UserReport::count();
        $meta = array('page'=>$page,'pages'=>$page,'perpage'=>10,'total'=>$user_report_count);
        return response(array('meta'=>$meta,'data'=>$data), Response::HTTP_OK);
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
        $data['report_count'] = Post::where('reports','>','0')->count();
        return view('admin.reports.post.index', $data);
    }

    public function getReportPostData(Request $request)
    {
        $data = [];
        $page = $request->input('pagination') ? $request->input('pagination')['page'] :1;
        $skip = 10 * ($page - 1);
        $data = Post::with('image','user.avatar')->where('reports','>','0')->take(10)->skip($skip)->get();
        $post_count = Post::count();
        $meta = array('page'=>$page,'pages'=>$page,'perpage'=>10,'total'=>$post_count);

        return response(array('meta'=>$meta,'data'=>$data), Response::HTTP_OK);
    }

    public function viewPost($slug)
    {
        $data = [];
        $data = Post::with('image','user.avatar')->where('slug',$slug)->first();
        $data['post'] = $data;
        return view('admin.reports.post.view', $data);
    }

    public function removePost($slug)
    {
        $currentPost = Post::where('slug',$slug)->first();
        if (!isset($currentPost)) {
            return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No Post exists']);
        }
        $currentPost->delete();
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
