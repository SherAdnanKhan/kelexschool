<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\Art;
use App\Models\User;


class ArtController extends BaseController
{
    public function getAll()
    {
        $arts = Art::with('children')->where('parent_id', null)->get();
        return $this->sendResponse($arts, 'All arts record');
    }

    public function store(Request $request) 
    {
        $returnData = [];
        $parent_id = null;

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:arts,name',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            if($request->has('parent_id')) {
                $parent_id = $request->parent_id;
            }
            $input = $request->all();
            $input['parent_id'] = $parent_id;
            $art = Art::create($input);
            $returnData['art'] =  $art;
            
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'New art added successfully.');

    }

    public function userArtSection(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'art_id' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $user->art_id = $request->art_id;
            $user->update();
            $updated_user = User::with('feel', 'art.parent')->find($user->id);
            $returnData['user'] = $updated_user;
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Your art successfully added');

    }

    public function searchArt(Request $request)
    {
        $returnData = [];
        try {
            if($request->has('art')) {
                $arts = Art::withCount('children')->where([ ['name', 'LIKE', '%'.$request->art.'%'], ['parent_id', null]])->get();
            }else {
              $arts = Art::withCount('children')->where('parent_id', null)->get();  
            }
            $returnData['arts'] = $arts;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'your art search');

    }

    public function searchChildArt(Request $request)
    {
        $returnData = [];
        $validator = Validator::make($request->all(), [
            'parent_art_id' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            if($request->has('child_art')) { 
                $arts = Art::where([['parent_id', $request->parent_art_id], ['name', 'LIKE', '%'.$request->child_art.'%']])->get();
            }else {
                $arts = Art::where('parent_id', $request->parent_art_id)->get();
            }
            $returnData['child_arts'] = $arts;
        }
        catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'your child art search');

    }

    public function show($id)
    {
        try {
            $art = Art::findOrFail($id);
            $returnData['art'] = $art;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'your art search');
       
    }

}
