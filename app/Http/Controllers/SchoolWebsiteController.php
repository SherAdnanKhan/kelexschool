<?php

namespace App\Http\Controllers;

use App\Traits\SchoolTrait;
use App\Models\Kelex_campus;
use Illuminate\Http\Request;
use App\Models\Kelex_employee;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

class SchoolWebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use SchoolTrait;
    public function __construct()
    {
        $url = URL::current();
        $url = parse_url($url);
        $url = $url['host'];
        $result = $this->getcampusdetails($url);

        if ($result == null) {
            return redirect('/login');
            die;
        }

        $employee = $this->getemployeedetails($result);
        $classes = $this->getClasses($result);
        $result = json_decode(json_encode($result),true);
        $classes = json_decode(json_encode($classes), true);
        $data = ['campusdetails' => $result, 'employees' => $employee, 'classes' => $classes];
        Session::put('campus_info', $data);
        //  dd($data);
    }
    public function index()
    {
        $data = ['campusdetails' => Session::get('campus_info')['campusdetails'], 'employees' => Session::get('campus_info')['employees'], 'classes' =>  Session::get('campus_info')['classes']];

        return view('Schoolwebsite.index')->with($data);
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
        //
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
