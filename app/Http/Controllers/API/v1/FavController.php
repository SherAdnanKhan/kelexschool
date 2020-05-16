<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\Fav;
use App\Models\USer;

class FavController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function favs()
    {
        $returnData = [];
        $faved_user_ids = [];
        $user = Auth::guard('api')->user();
        $favs = Fav::where('faved_by', $user->id)->get(['faved_to']);
        foreach($favs as $fav) {
            array_push($faved_user_ids, $fav->faved_to);
        }
        $all_faved_users = User::with('avatars', 'art.parent', 'galleries')->whereIn('id', $faved_user_ids)->get();
        
        $returnData['faves'] = $all_faved_users;
        return $this->sendResponse($returnData, 'User faves');
    }

    public function fav_by()
    {
        $returnData = [];
        $faved_user_ids = [];
        $user = Auth::guard('api')->user();
        $favs = Fav::where('faved_to', $user->id)->get(['faved_by']);
        foreach($favs as $fav) {
            array_push($faved_user_ids, $fav->faved_by);
        }
        $all_faved_users = User::with('avatars', 'art.parent', 'galleries')->whereIn('id', $faved_user_ids)->get();
        
        $returnData['faves'] = $all_faved_users;
        return $this->sendResponse($returnData, 'User faved By');
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
            'faved_to' => 'required',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            $user_check = User::findOrFail($request->faved_to);
            $check_already_fav = Fav::where([ ['faved_by', $user->id], ['faved_to', $request->faved_to] ])->first();
            if (isset($check_already_fav)) {
                return $this->sendError('Already Exists', ['error'=>'Already Fav', 'message' => 'You already added faved to this user']);
            }

            $fav = new Fav;
            $fav->faved_by = $user->id;
            $fav->faved_to = $request->faved_to;
            $fav->save(); 

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Faved Added');
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
    public function destroy($unfaved_to)
    {
        $user = Auth::guard('api')->user();

        try {
            $user_check = User::findOrFail($unfaved_to);
            $check_already_fav = Fav::where([ ['faved_by', $user->id], ['faved_to', $unfaved_to] ])->first();
            if (!$check_already_fav) {
                return $this->sendError('Not faved', ['error'=>'Not faved list', 'message' => 'You are not faved to this user']);
            }

            $check_already_fav->delete(); 

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse([], 'Unfaved Sucessfully');
    }

    public function favCounts()
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $fav_by_count = Fav::where('faved_to', $user->id)->get()->count();
        $fav_to_count = Fav::where('faved_by', $user->id)->get()->count();
        $returnData['fav_by_count'] = $fav_by_count;
        $returnData['fav_to_count'] = $fav_to_count;
        return $this->sendResponse($returnData, 'Count Faves');
    }
}
