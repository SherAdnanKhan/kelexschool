<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
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
}
