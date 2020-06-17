<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\Feed;
use App\Models\Image;

class MzFalshController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returnData = [];
        $user = Auth::guard('api')->user();

        $feeds = Feed::with('image', 'parent')->where('created_by', $user->id)->get();
        $returnData['feeds'] = $feeds;
        return $this->sendResponse($returnData, 'All feeds');

    }

    public function otherFeed($user_id)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();

        $feeds = Feed::with('image', 'parent')->where('created_by', $user_id)->get();
        $returnData['feeds'] = $feeds;
        return $this->sendResponse($returnData, 'All feeds');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'feed' => 'required|max:200',
            'image' => env('IMAGE_TYPE_SIZE', '1000'),
            'video' => env('DOCUMENT_SIZE', '2000'),
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            if (isset($request->feed_id)) {
                $isFeed = Feed::find($request->feed_id);
                if(!isset($isFeed)) {
                    return $this->sendError('Invalid Feed', ['error'=>'Unauthorised Feed', 'message' => 'Please add correct feed']);
                }
            }
            $feedtype = 0;
            if($request->has('image')) {
                $feedtype  = 1;
            }
            else if ($request->has('video')) {
                $feedtype  = 2;
            }
            $feed = new Feed;
            $feed->feed = $request->feed;
            $feed->parent_id = $request->feed_id ? $request->feed_id : null;
            $feed->feed_type = $feedtype;
            $feed->feel_color = $user->feel_color;
            $feed->created_by = $user->id;
            $feed->save(); 

            if($request->has('image') || $request->has('video')) {
                if ($request->has('image')) {
                    $image_recived = $this->uploadImage($request->image, "feeds/");
                }

                if ($request->has('video')) {
                    $image_recived = $this->uploadImage($request->video, "feeds/");
                }
                
                $image = new Image();
                $image->title = $image_recived['image_name'];
                $image->path = $image_recived['image_path'];
                $image->image_type = 'App\Models\Feed';
                $image->image_id = $feed->id;
                $image->created_by = $user->id;
                $image->save();
            }

            $returnData['feed'] = $feed;
            $returnData['feed']['image'] = $image;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Feed Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
