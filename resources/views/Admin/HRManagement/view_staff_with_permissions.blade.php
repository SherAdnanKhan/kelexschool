@extends('Admin.layout.master')
@section("page-css")
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section("content")

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                        <div class="container">
            <div class="pt-5">
                <div class="row d-flex justify-content-center align-items-center">
                    <h1>Staff Details</h1>
                </div>
                    
           {{--Table data display--}}         
           
                </div>
                <br>
                <br>
                <div class="table-responsive">
                <table class="table table-dark">
                    <thead>
                      <tr>
                        <th scope="col">Staff Name</th>
                        <th scope="col">Staff Email</th>
                        <th scope="col">Edit</th>
                      </tr>
                    </thead>
                    <tbody id="displaydata">
                        
                      @foreach ($staffs as $staff)
                      <tr id="row{{$staff->id}}">
                        <td>{{$staff->username}}</td>
                        <td>{{$staff->email}}</td>
                        <td>
                          <a href="editstaff/{{$staff->id}}" class="btn btn-success">Edit</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>

                  <a href="{{route('staff')}}" class="btn btn-primary">Add New Staff</a>
            </div>
        </div>
@endsection
