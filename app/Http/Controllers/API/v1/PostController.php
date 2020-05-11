<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\Post;
use App\Models\Image;
use App\Models\Gallery;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'title' => 'required',
            'gallery_id' => 'required',
            'image' => 'image|max:2000'
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            $gallery = Gallery::findOrFail($request->gallery_id);
            if ($gallery->created_by != $user->id) {
                return $this->sendError('Invalid Gallery', ['error'=>'Unauthorised Gallery', 'message' => 'Please post into your gallery']);
            }
            $post = new Post;
            $post->title = $request->title;
            $post->gallery_id = $request->gallery_id;
            $post->description = $request->description ? $request->description : null;
            $post->created_by = $user->id;
            $post->save(); 

            if($request->has('image')) {
                $image_recived = $this->uploadImage($request->image, "posts/");
                $image = new Image();
                $image->title = $image_recived['image_name'];
                $image->path = $image_recived['image_path'];
                $image->image_type = 'App\Models\Post';
                $image->image_id = $post->id;
                $image->created_by = $user->id;
                $image->save();
            }

            $returnData['post'] = $post;
            $returnData['post']['image'] = $image;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Exhibit Added');
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
