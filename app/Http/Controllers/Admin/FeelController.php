<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use Storage;
use App\Models\Feel;

class FeelController extends BaseController
{
    public function index()
    {
        $data = [];
        $data['feels'] = $feels = Feel::all();
        return view('admin.feels.index', $data);
    }

    public function show($id)
    {
        $data = [];
        $data['feel'] = $feel = Feel::find($id);
        return view('admin.feels.edit', $data);
    }

    public function update($id ,Request $request)
    {
      $feel =[];
        try {
            $feel = Feel::find($id);
            if($request->has('feel_icon') && isset($request->feel_icon)) {
                $image_recived = $this->uploadImage($request->feel_icon, "feels/");
                $feel->image_path = $image_recived['image_path'];
            }
            $feel->color_code = $request->color_code;
            $feel->save();
          }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($feel, 'Feel Updated');
    }
}
