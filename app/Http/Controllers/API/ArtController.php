<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use App\Models\Art;


class ArtController extends BaseController
{
    public function getAll()
    {
        $arts = Art::with('children')->where('parent_id', null)->get();
        return $this->sendResponse($arts, 'All arts record');
    }

    public function store(Request $request) {
        $returnData = [];
        $parent_id = null;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
   
        if ($validator->fails()){
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
}
