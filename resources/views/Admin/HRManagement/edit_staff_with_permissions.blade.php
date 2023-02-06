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
                    <div class="card m-b-20">

                        <div class="row">
                            <div class="col-2">
                                <a href='/showstaff' class="btn btn-primary">Show Existing Non Teaching Employee</a>

                            </div>
                        </div>



                            <h4 class="register-heading">Edit Staff Details</h4>

                            <form method="post" action="{{ route('update-staff')}}" id="insertcampus" enctype="multipart/form-data">
                               @csrf
                                <div class="row register-form">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="Sname">Staff User Name:</label>
                                        <small id="username_error" class="form-text text-danger"></small>
                                        <input type="hidden" name="id" value="{{$staff->id}}" />
                                            <input type="text" class="form-control" name="username" placeholder="Enter user name *" value="{{$staff->username}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="SEmail">Email</label>
                                        <small id="email_error" class="form-text text-danger"></small>
                                            <input type="text" class="form-control"  name="email" placeholder="Enter Email *" value="{{$staff->email}}" />
                                        </div>
                                    </div>
                                   

                                </div>

                                <div class="row">
                                    <div class="col-md-2"><h5>Permssions</h5></div>
                                </div>
                                <div class="row">
                                    <div class="card-body">
                                        <div class="card m-b-20">
                                            <div class="col-sm-12">
                                            <div class="card">
                                        </div>
                            <?php
                             $permissions= json_decode(Session::get('permissions'));
                             $staffpermission=json_decode($staff->permissions);
                            // dd($staffpermission);
                            ?>
                                        @if(isset($permissions->usermanagment->status)=="1")
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group mb-6">
                                                        <div class="input-group-prepend">
                                                        <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="USER MANAGMENT">
                                                            <div class="input-group-text">
                                                            <input type="checkbox" id="checkbox" data-id="usermanagment" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->usermanagment->status)=="1"){ echo 'checked'; } ?> name="role_per[usermanagment][status]" value="1">
                                                            </div>
                                                        </div>

                                                        </div>
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <span class="button-checkbox">
                                                            <button class="usermanagment" type="button" class="btn" data-color="primary">View</button>
                                                            <input  class="usermanagment" type="checkbox" name="role_per[usermanagment][view]" class="hidden" <?php if(isset($staffpermission->usermanagment->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                        </span>
                                                        <span class="button-checkbox">
                                                            <button  class="usermanagment" type="button" class="btn" data-color="success">Create</button>
                                                            <input  class="usermanagment" type="checkbox" class="hidden"  name="role_per[usermanagment][create]" <?php if(isset($staffpermission->usermanagment->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                        </span>
                                                        <span class="button-checkbox">
                                                            <button  class="usermanagment" type="button" class="btn" data-color="info">Update</button>
                                                            <input  class="usermanagment" type="checkbox" class="hidden"  name="role_per[usermanagment][update]" <?php if(isset($staffpermission->usermanagment->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                        </span>
                                                        <span class="button-checkbox">
                                                            <button  class="usermanagment" type="button" class="btn" data-color="warning"  name="role_per[usermanagment][delete]">Delete</button>
                                                            <input  class="usermanagment" type="checkbox" class="hidden" name="role_per[usermanagment][delete]" <?php if(isset($staffpermission->usermanagment->delete)=="1"){ echo 'checked'; } ?> value="1" />
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                        @endif
                                        @if(isset($permissions->acadamics->status)=="1")
                                                <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Acadamics">
                                                                <div class="input-group-text">
                                                                <input id="checkbox" type="checkbox" data-id ="acadamaics" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->acadamics->status)=="1"){ echo 'checked'; } ?> name="role_per[acadamics][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                </div>
                                            </div>
                                            @endif
                                        @if(isset($permissions->acadamics->student_manage->view)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="STUDENT MANAGAMENT">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="acadamaics" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->acadamics->student_manage->status)=="1"){ echo 'checked'; } ?> name="role_per[acadamics][student_manage][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="acadamaics"class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" class="acadamaics" name="role_per[acadamics][student_manage][view]" class="hidden" <?php if(isset($staffpermission->acadamics->student_manage->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="acadamaics"class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="acadamaics" class="hidden"  name="role_per[acadamics][student_manage][create]" <?php if(isset($staffpermission->acadamics->student_manage->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="acadamaics"class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="acadamaics" class="hidden"  name="role_per[acadamics][student_manage][update]" <?php if(isset($staffpermission->acadamics->student_manage->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="acadamaics" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="acadamaics" class="hidden" <?php if(isset($staffpermission->acadamics->student_manage->delete)=="1"){ echo 'checked'; } ?> name="role_per[acadamics][student_manage][delete]"  value="1"/>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if(isset($permissions->acadamics->session->status)=="1")
                                            <div class="row" >
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control " aria-label="Text input with checkbox" readonly value ="SESSION / BATCH">
                                                                <div class="input-group-text">
                                                                <input  class="acadamaics" type="checkbox" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->acadamics->session->status)=="1"){ echo 'checked'; } ?> name="role_per[acadamics][session][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="primary">View</button>
                                                                <input class="acadamaics" type="checkbox" name="role_per[acadamics][session][view]" class="hidden" <?php if(isset($staffpermission->acadamics->session->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="success">Create</button>
                                                                <input class="acadamaics" type="checkbox" class="hidden"  name="role_per[acadamics][session][create]" <?php if(isset($staffpermission->acadamics->session->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="info">Update</button>
                                                                <input class="acadamaics" type="checkbox" class="hidden"  name="role_per[acadamics][session][update]" <?php if(isset($staffpermission->acadamics->session->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input class="acadamaics" type="checkbox" class="hidden" <?php if(isset($staffpermission->acadamics->session->delete)=="1"){ echo 'checked'; } ?> name="role_per[acadamics][session][delete]" value="1" />
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @if(isset($permissions->acadamics->classess->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="CLASSES / PROGRAM">
                                                                <div class="input-group-text">
                                                                <input class="acadamaics" type="checkbox" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->acadamics->classess->status)=="1"){ echo 'checked'; } ?> name="role_per[acadamics][classess][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="primary">View</button>
                                                                <input class="acadamaics" type="checkbox" name="role_per[acadamics][classess][view]" class="hidden" <?php if(isset($staffpermission->acadamics->classess->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="success">Create</button>
                                                                <input class="acadamaics" type="checkbox" class="hidden"  name="role_per[acadamics][classess][create]" <?php if(isset($staffpermission->acadamics->classess->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input class="acadamaics" type="checkbox" class="hidden"  name="role_per[acadamics][classess][update]" <?php if(isset($staffpermission->acadamics->classess->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="acadamaics"type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input class="acadamaics" type="checkbox" class="hidden" <?php if(isset($staffpermission->acadamics->classess->delete)=="1"){ echo 'checked'; } ?> name="role_per[acadamics][classess][delete]" value="1" />
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @if(isset($permissions->acadamics->sections->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="SECTION /SEMESTER">
                                                                <div class="input-group-text">
                                                                <input  class="acadamaics" type="checkbox" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->acadamics->sections->status)=="1"){ echo 'checked'; } ?> name="role_per[acadamics][sections][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="primary">View</button>
                                                                <input  class="acadamaics" type="checkbox" name="role_per[acadamics][sections][view]" class="hidden" <?php if(isset($staffpermission->acadamics->sections->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="success">Create</button>
                                                                <input  class="acadamaics" type="checkbox" class="hidden"  name="role_per[acadamics][sections][create]" <?php if(isset($staffpermission->acadamics->sections->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="info">Update</button>
                                                                <input class="acadamaics" type="checkbox" class="hidden"  name="role_per[acadamics][sections][update]" <?php if(isset($staffpermission->acadamics->sections->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input class="acadamaics" type="checkbox" class="hidden" <?php if(isset($staffpermission->acadamics->sections->delete)=="1"){ echo 'checked'; } ?> name="role_per[acadamics][sections][delete]" value="1" />
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @if(isset($permissions->acadamics->subjects->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Subjects">
                                                                <div class="input-group-text">
                                                                <input class="acadamaics" type="checkbox" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->acadamics->subjects->status)=="1"){ echo 'checked'; } ?> name="role_per[acadamics][subjects][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="primary">View</button>
                                                                <input class="acadamaics" type="checkbox" name="role_per[acadamics][subjects][view]" class="hidden" <?php if(isset($staffpermission->acadamics->subjects->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="success">Create</button>
                                                                <input class="acadamaics" type="checkbox" class="hidden"  name="role_per[acadamics][subjects][create]" <?php if(isset($staffpermission->acadamics->subjects->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="info">Update</button>
                                                                <input class="acadamaics" type="checkbox" class="hidden"  name="role_per[acadamics][subjects][update]" <?php if(isset($staffpermission->acadamics->subjects->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="acadamaics" type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input class="acadamaics" type="checkbox" class="hidden" <?php if(isset($staffpermission->acadamics->subjects->delete)=="1"){ echo 'checked'; } ?>  name="role_per[acadamics][subjects][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @if(isset($permissions->admissionwithdraw->status)=="1")

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Admission Withdraw">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" id="checkbox" data-id="addmission-withdraw" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->admissionwithdraw->status)=="1"){ echo 'checked'; } ?> name="role_per[admissionwithdraw][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->admissionwithdraw->withdraw_register->status)=="1")

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="With-Draw Register">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="addmission-withdraw" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->admissionwithdraw->withdraw_register->status)=="1"){ echo 'checked'; } ?> name="role_per[admissionwithdraw][withdraw_register][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button class="addmission-withdraw" type="button" class="btn" data-color="primary">View</button>
                                                                <input class="addmission-withdraw" type="checkbox" name="role_per[admissionwithdraw][withdraw_register][view]" class="hidden" <?php if(isset($staffpermission->admissionwithdraw->withdraw_register->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="addmission-withdraw" type="button" class="btn" data-color="success">Create</button>
                                                                <input class="addmission-withdraw" type="checkbox" class="hidden"  name="role_per[admissionwithdraw][withdraw_register][create]" <?php if(isset($staffpermission->admissionwithdraw->withdraw_register->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="addmission-withdraw" type="button" class="btn" data-color="info">Update</button>
                                                                <input class="addmission-withdraw" type="checkbox" class="hidden"  name="role_per[admissionwithdraw][withdraw_register][update]" <?php if(isset($staffpermission->admissionwithdraw->withdraw_register->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="addmission-withdraw" type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input class="addmission-withdraw" type="checkbox" class="hidden" <?php if(isset($staffpermission->admissionwithdraw->withdraw_register->delete)=="1"){ echo 'checked'; } ?>  name="role_per[admissionwithdraw][withdraw_register][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->registermanagment->status)=="1")

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Register Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="addmission-withdraw" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->registermanagment->status)=="1"){ echo 'checked'; } ?> name="role_per[registermanagment][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button class="addmission-withdraw" type="button" class="btn" data-color="primary">View</button>
                                                                <input class="addmission-withdraw" type="checkbox" name="role_per[registermanagment][view]" class="hidden" <?php if(isset($staffpermission->registermanagment->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="addmission-withdraw" type="button" class="btn" data-color="success">Create</button>
                                                                <input class="addmission-withdraw" type="checkbox" class="hidden"  name="role_per[registermanagment][create]" <?php if(isset($staffpermission->registermanagment->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="addmission-withdraw" type="button" class="btn" data-color="info">Update</button>
                                                                <input class="addmission-withdraw" type="checkbox" class="hidden"  name="role_per[registermanagment][update]" <?php if(isset($staffpermission->registermanagment->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="addmission-withdraw" type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input class="addmission-withdraw" type="checkbox" class="hidden" <?php if(isset($staffpermission->registermanagment->delete)=="1"){ echo 'checked'; } ?>  name="role_per[registermanagment][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->correspondence->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="correspondence">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" id="checkbox" data-id="correspondance" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->correspondence->status)=="1"){ echo 'checked'; } ?> name="role_per[correspondence][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                </div>

                                            </div>
                                        @endif
                                        @if(isset($permissions->complaintletter->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Complaint Letter Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="correspondance" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->complaintletter->status)=="1"){ echo 'checked'; } ?> name="role_per[complaintletter][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button class="correspondance" type="button" class="btn" data-color="primary">View</button>
                                                                <input class="correspondance" type="checkbox" name="role_per[complaintletter][view]" class="hidden" <?php if(isset($staffpermission->complaintletter->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="correspondance" type="button" class="btn" data-color="success">Create</button>
                                                                <input class="correspondance" type="checkbox" class="hidden"  name="role_per[complaintletter][create]" <?php if(isset($staffpermission->complaintletter->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="correspondance" type="button" class="btn" data-color="info">Update</button>
                                                                <input class="correspondance" type="checkbox" class="hidden"  name="role_per[complaintletter][update]" <?php if(isset($staffpermission->complaintletter->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="correspondance" type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input class="correspondance" type="checkbox" class="hidden" <?php if(isset($staffpermission->complaintletter->delete)=="1"){ echo 'checked'; } ?>  name="role_per[complaintletter][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->showcause->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Showcause Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="correspondance" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->showcause->status)=="1"){ echo 'checked'; } ?> name="role_per[showcause][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button class="correspondance" type="button" class="btn" data-color="primary">View</button>
                                                                <input class="correspondance" type="checkbox" name="role_per[showcause][view]" class="hidden" <?php if(isset($staffpermission->showcause->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="correspondance" type="button" class="btn" data-color="success">Create</button>
                                                                <input class="correspondance" type="checkbox" class="hidden"  name="role_per[showcause][create]" <?php if(isset($staffpermission->showcause->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="correspondance"  type="button" class="btn" data-color="info">Update</button>
                                                                <input class="correspondance"  type="checkbox" class="hidden"  name="role_per[showcause][update]" <?php if(isset($staffpermission->showcause->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button class="correspondance"  type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input class="correspondance" type="checkbox" class="hidden" <?php if(isset($staffpermission->showcause->delete)=="1"){ echo 'checked'; } ?>  name="role_per[showcause][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>

                                        @endif
                                        @if(isset($permissions->notification->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Notification">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="correspondance" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->notification->status)=="1"){ echo 'checked'; } ?> name="role_per[notification][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button"  class="correspondance"class="btn" data-color="primary">View</button>
                                                                <input type="checkbox"  class="correspondance" name="role_per[notification][view]" class="hidden" <?php if(isset($staffpermission->notification->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"  class="correspondance"class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="correspondance" class="hidden"  name="role_per[notification][create]" <?php if(isset($staffpermission->notification->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"  class="correspondance"class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="correspondance" class="hidden"  name="role_per[notification][update]" <?php if(isset($staffpermission->notification->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="correspondance" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="correspondance" class="hidden" <?php if(isset($staffpermission->notification->delete)=="1"){ echo 'checked'; } ?>  name="role_per[notification][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>

                                        @endif
                                        @if(isset($permissions->fee_managament->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Fee Managnent">
                                                                <div class="input-group-text">
                                                                <input type="checkbox"  id="checkbox" data-id="fee_manamgemnt" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->fee_managament->status)=="1"){ echo 'checked'; } ?> name="role_per[fee_managament][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->fee_managament->fee_category->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Define Fee Category">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="fee_manamgemnt" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->fee_managament->fee_category->status)=="1"){ echo 'checked'; } ?> name="role_per[fee_managament][fee_category][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt" class="btn" class = "fee_manamgemnt" data-color="primary">View</button>
                                                                <input type="checkbox" class = "fee_manamgemnt" name="role_per[fee_managament][fee_category][view]" class="hidden" <?php if(isset($staffpermission->fee_managament->fee_category->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button "class = "fee_manamgemnt" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class = "fee_manamgemnt" class="hidden"  name="role_per[fee_managament][fee_category][create]" <?php if(isset($staffpermission->fee_managament->fee_category->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class = "fee_manamgemnt"class="hidden"   name="role_per[fee_managament][fee_category][update]" <?php if(isset($staffpermission->fee_managament->fee_category->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class = "fee_manamgemnt" class="hidden" <?php if(isset($staffpermission->fee_managament->fee_category->delete)=="1"){ echo 'checked'; } ?>  name="role_per[fee_managament][fee_category][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->fee_managament->define_fee->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Define Fee">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class = "fee_manamgemnt"aria-label="Checkbox for following text input" <?php if(isset($staffpermission->fee_managament->define_fee->status)=="1"){ echo 'checked'; } ?> name="role_per[fee_managament][define_fee][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button"class = "fee_manamgemnt" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox"class = "fee_manamgemnt" name="role_per[fee_managament][define_fee][view]" class="hidden" <?php if(isset($staffpermission->fee_managament->define_fee->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt"class="btn" data-color="success">Create</button>
                                                                <input type="checkbox"class = "fee_manamgemnt" class="hidden"  name="role_per[fee_managament][define_fee][create]" <?php if(isset($staffpermission->fee_managament->define_fee->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt"class="btn" data-color="info">Update</button>
                                                                <input type="checkbox"class = "fee_manamgemnt" class="hidden"  name="role_per[fee_managament][define_fee][update]" <?php if(isset($staffpermission->fee_managament->define_fee->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt"class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox"class = "fee_manamgemnt" class="hidden" <?php if(isset($staffpermission->fee_managament->define_fee->delete)=="1"){ echo 'checked'; } ?>  name="role_per[fee_managament][define_fee][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->fee_managament->fee_collection->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Fee Collection">
                                                                <div class="input-group-text">
                                                                <input type="checkbox"class = "fee_manamgemnt" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->fee_managament->fee_collection->status)=="1"){ echo 'checked'; } ?> name="role_per[fee_managament][fee_collection][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button"class = "fee_manamgemnt" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox"class = "fee_manamgemnt" name="role_per[fee_managament][fee_collection][view]" class="hidden" <?php if(isset($staffpermission->fee_managament->fee_collection->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt"class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class = "fee_manamgemnt"class="hidden"  name="role_per[fee_managament][fee_collection][create]" <?php if(isset($staffpermission->fee_managament->fee_collection->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"class = "fee_manamgemnt" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox"class = "fee_manamgemnt" class="hidden"  name="role_per[fee_managament][fee_collection][update]" <?php if(isset($staffpermission->fee_managament->fee_collection->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt"class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class = "fee_manamgemnt"class="hidden" <?php if(isset($staffpermission->fee_managament->fee_collection->delete)=="1"){ echo 'checked'; } ?>  name="role_per[fee_managament][fee_collection][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->fee_managament->fee_voucher->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Print Fee Voucher">
                                                                <div class="input-group-text">
                                                                <input type="checkbox"class = "fee_manamgemnt" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->fee_managament->fee_voucher->status)=="1"){ echo 'checked'; } ?> name="role_per[fee_managament][fee_voucher][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt"class="btn" data-color="primary">View</button>
                                                                <input type="checkbox"class = "fee_manamgemnt" name="role_per[fee_managament][fee_voucher][view]" class="hidden" <?php if(isset($staffpermission->fee_managament->fee_voucher->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt"class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class = "fee_manamgemnt"class="hidden"  name="role_per[fee_managament][fee_voucher][create]" <?php if(isset($staffpermission->fee_managament->fee_voucher->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"class = "fee_manamgemnt" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class = "fee_manamgemnt"class="hidden"  name="role_per[fee_managament][fee_voucher][update]" <?php if(isset($staffpermission->fee_managament->fee_voucher->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt"class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class = "fee_manamgemnt"class="hidden" <?php if(isset($staffpermission->fee_managament->fee_voucher->delete)=="1"){ echo 'checked'; } ?>  name="role_per[fee_managament][fee_voucher][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->fee_managament->fee_register->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Fee register">
                                                                <div class="input-group-text">
                                                                <input type="checkbox"class = "fee_manamgemnt" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->fee_managament->fee_register->status)=="1"){ echo 'checked'; } ?> name="role_per[fee_managament][fee_register][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button"class = "fee_manamgemnt" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" class = "fee_manamgemnt"name="role_per[fee_managament][fee_register][view]" class="hidden" <?php if(isset($staffpermission->fee_managament->fee_register->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"class = "fee_manamgemnt" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class = "fee_manamgemnt"class="hidden"  name="role_per[fee_managament][fee_register][create]" <?php if(isset($staffpermission->fee_managament->fee_register->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"class = "fee_manamgemnt" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox"class = "fee_manamgemnt" class="hidden"  name="role_per[fee_managament][fee_register][update]" <?php if(isset($staffpermission->fee_managament->fee_register->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt"class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class = "fee_manamgemnt"class="hidden" <?php if(isset($staffpermission->fee_managament->fee_register->delete)=="1"){ echo 'checked'; } ?>  name="role_per[fee_managament][fee_register][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->fee_managament->family_accounts->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Family Accounts">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class = "fee_manamgemnt" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->fee_managament->family_accounts->status)=="1"){ echo 'checked'; } ?> name="role_per[fee_managament][family_accounts][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button"class = "fee_manamgemnt" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox"class = "fee_manamgemnt" name="role_per[fee_managament][family_accounts][view]" class="hidden" <?php if(isset($staffpermission->fee_managament->family_accounts->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt"class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class = "fee_manamgemnt"class="hidden"  name="role_per[fee_managament][family_accounts][create]" <?php if(isset($staffpermission->fee_managament->family_accounts->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"class = "fee_manamgemnt" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox"class = "fee_manamgemnt" class="hidden"  name="role_per[fee_managament][family_accounts][update]" <?php if(isset($staffpermission->fee_managament->family_accounts->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class = "fee_manamgemnt"class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class = "fee_manamgemnt"class="hidden" <?php if(isset($staffpermission->fee_managament->family_accounts->delete)=="1"){ echo 'checked'; } ?>  name="role_per[fee_managament][family_accounts][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->std_attendance->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Student Attendance">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" id="checkbox" data-id="std-attendance" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->std_attendance->status)=="1"){ echo 'checked'; } ?> name="role_per[std_attendance][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->std_attendance->application->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Applications">
                                                                <div class="input-group-text">
                                                                <input type="checkbox"  class="std-attendance"aria-label="Checkbox for following text input" <?php if(isset($staffpermission->std_attendance->application->status)=="1"){ echo 'checked'; } ?> name="role_per[std_attendance][application][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="std-attendance" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" class="std-attendance" name="role_per[std_attendance][application][view]" class="hidden" <?php if(isset($staffpermission->std_attendance->application->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="std-attendance" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="std-attendance" class="hidden"  name="role_per[std_attendance][application][create]" <?php if(isset($staffpermission->std_attendance->application->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="std-attendance" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="std-attendance" class="hidden"  name="role_per[std_attendance][application][update]" <?php if(isset($staffpermission->std_attendance->application->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="std-attendance" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="std-attendance" class="hidden" <?php if(isset($staffpermission->std_attendance->application->delete)=="1"){ echo 'checked'; } ?>  name="role_per[std_attendance][application][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->std_attendance->std_attendance_manage->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Attendance Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="std-attendance"  aria-label="Checkbox for following text input" <?php if(isset($staffpermission->std_attendance->std_attendance_manage->status)=="1"){ echo 'checked'; } ?> name="role_per[std_attendance][std_attendance_manage][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="std-attendance"  class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" class="std-attendance"  name="role_per[std_attendance][std_attendance_manage][view]" class="hidden" <?php if(isset($staffpermission->std_attendance->std_attendance_manage->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="std-attendance"  class="btn" data-color="success">Create</button>
                                                                <input type="checkbox"  class="std-attendance" class="hidden"  name="role_per[std_attendance][std_attendance_manage][create]" <?php if(isset($staffpermission->std_attendance->std_attendance_manage->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="std-attendance"  class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="std-attendance"  class="hidden"  name="role_per[std_attendance][std_attendance_manage][update]" <?php if(isset($staffpermission->std_attendance->std_attendance_manage->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"  class="std-attendance" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox"  class="std-attendance" class="hidden" <?php if(isset($staffpermission->std_attendance->std_attendance_manage->delete)=="1"){ echo 'checked'; } ?>  name="role_per[std_attendance][std_attendance_manage][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->std_attendance->non_present->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Non-Present Report">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="std-attendance"  aria-label="Checkbox for following text input" <?php if(isset($staffpermission->std_attendance->non_present->status)=="1"){ echo 'checked'; } ?> name="role_per[std_attendance][non_present][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button"  class="std-attendance" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox"  class="std-attendance" name="role_per[std_attendance][non_present][view]" class="hidden" <?php if(isset($staffpermission->std_attendance->non_present->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"  class="std-attendance" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="std-attendance"  class="hidden"  name="role_per[std_attendance][non_present][create]" <?php if(isset($staffpermission->std_attendance->non_present->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="std-attendance"  class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="std-attendance"  class="hidden"  name="role_per[std_attendance][non_present][update]" <?php if(isset($staffpermission->std_attendance->non_present->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="std-attendance"  class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="std-attendance"  class="hidden" <?php if(isset($staffpermission->std_attendance->non_present->delete)=="1"){ echo 'checked'; } ?>  name="role_per[std_attendance][non_present][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->hr_managment->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="HR Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" id="checkbox" data-id="hr_manag" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->hr_managment->status)=="1"){ echo 'checked'; } ?> name="role_per[hr_managment][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                </div>

                                            </div>

                                            @endif
                                        @if(isset($permissions->hr_managment->emp_categories->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Employee Categories">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="hr_manag" class="hr_manag" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->hr_managment->emp_categories->status)=="1"){ echo 'checked'; } ?> name="role_per[hr_managment][emp_categories][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="hr_manag" class="hr_manag"class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" class="hr_manag" class="hr_manag"name="role_per[hr_managment][emp_categories][view]" class="hidden" <?php if(isset($staffpermission->hr_managment->emp_categories->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="hr_manag" class="hr_manag"class="btn" data-color="success">Create</button>
                                                                <input type="checkbox"class="hr_manag" class="hr_manag" class="hidden"  name="role_per[hr_managment][emp_categories][create]" <?php if(isset($staffpermission->hr_managment->emp_categories->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="hr_manag" class="hr_manag"class="btn" data-color="info">Update</button>
                                                                <input type="checkbox"class="hr_manag" class="hr_manag" class="hidden"  name="role_per[hr_managment][emp_categories][update]" <?php if(isset($staffpermission->hr_managment->emp_categories->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"class="hr_manag" class="hr_manag" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox"class="hr_manag" class="hr_manag" class="hidden" <?php if(isset($staffpermission->hr_managment->emp_categories->delete)=="1"){ echo 'checked'; } ?>  name="role_per[hr_managment][emp_categories][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->hr_managment->emp_manage->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Employee Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox"class="hr_manag" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->hr_managment->emp_manage->status)=="1"){ echo 'checked'; } ?> name="role_per[hr_managment][emp_manage][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button"class="hr_manag" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox"class="hr_manag" name="role_per[hr_managment][emp_manage][view]" class="hidden" <?php if(isset($staffpermission->hr_managment->emp_manage->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"class="hr_manag" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox"class="hr_manag" class="hidden"  name="role_per[hr_managment][emp_manage][create]" <?php if(isset($staffpermission->hr_managment->emp_manage->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"class="hr_manag" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox"class="hr_manag" class="hidden"  name="role_per[hr_managment][emp_manage][update]" <?php if(isset($staffpermission->hr_managment->emp_manage->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"class="hr_manag" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox"class="hr_manag" class="hidden" <?php if(isset($staffpermission->hr_managment->emp_manage->delete)=="1"){ echo 'checked'; } ?>  name="role_per[hr_managment][emp_manage][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>

                                            @endif
                                        @if(isset($permissions->hr_managment->emp_attendance->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Employee Attendance">
                                                                <div class="input-group-text">
                                                                <input type="checkbox"class="hr_manag" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->hr_managment->emp_attendance->status)=="1"){ echo 'checked'; } ?> name="role_per[hr_managment][emp_attendance][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="hr_manag" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox"class="hr_manag" name="role_per[hr_managment][emp_attendance][view]" class="hidden" <?php if(isset($staffpermission->hr_managment->emp_attendance->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"  class="hr_manag" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox"class="hr_manag" class="hidden"  name="role_per[hr_managment][emp_attendance][create]" <?php if(isset($staffpermission->hr_managment->emp_attendance->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="hr_manag" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox"class="hr_manag" class="hidden"  name="role_per[hr_managment][emp_attendance][update]" <?php if(isset($staffpermission->hr_managment->emp_attendance->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="hr_manag" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox"class="hr_manag" class="hidden" <?php if(isset($staffpermission->hr_managment->emp_attendance->delete)=="1"){ echo 'checked'; } ?>  name="role_per[hr_managment][emp_attendance][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>

                                            @endif
                                        @if(isset($permissions->accounts->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Accounts">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" id="checkbox" data-id="accounts" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->accounts->status)=="1"){ echo 'checked'; } ?> name="role_per[accounts][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                </div>

                                            </div>

                                            @endif
                                        @if(isset($permissions->accounts->asset_category->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Assets Category">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="accounts" class="accounts" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->accounts->asset_category->status)=="1"){ echo 'checked'; } ?> name="role_per[accounts][asset_category][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="accounts" class="accounts" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" class="accounts" class="accounts" name="role_per[accounts][asset_category][view]" class="hidden" <?php if(isset($staffpermission->accounts->asset_category->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="accounts" class="accounts" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox"class="accounts" class="accounts"  class="hidden"  name="role_per[accounts][asset_category][create]" <?php if(isset($staffpermission->accounts->asset_category->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="accounts" class="accounts" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="accounts" class="accounts" class="hidden"  name="role_per[accounts][asset_category][update]" <?php if(isset($staffpermission->accounts->asset_category->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"class="accounts" class="accounts"  class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox"class="accounts" class="accounts"  class="hidden" <?php if(isset($staffpermission->accounts->asset_category->delete)=="1"){ echo 'checked'; } ?>  name="role_per[accounts][asset_category][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>


                                            @endif
                                        @if(isset($permissions->accounts->asset_managment->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Assets Managamnet">
                                                                <div class="input-group-text">
                                                                <input type="checkbox"class="accounts"  aria-label="Checkbox for following text input" <?php if(isset($staffpermission->accounts->asset_managment->status)=="1"){ echo 'checked'; } ?> name="role_per[accounts][asset_managment][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="accounts" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox"class="accounts"  name="role_per[accounts][asset_managment][view]" class="hidden" <?php if(isset($staffpermission->accounts->asset_managment->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="accounts" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="accounts" class="hidden"  name="role_per[accounts][asset_managment][create]" <?php if(isset($staffpermission->accounts->asset_managment->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="accounts" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox"class="accounts"  class="hidden"  name="role_per[accounts][asset_managment][update]" <?php if(isset($staffpermission->accounts->asset_managment->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"class="accounts"  class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="accounts" class="hidden" <?php if(isset($staffpermission->accounts->asset_managment->delete)=="1"){ echo 'checked'; } ?>  name="role_per[accounts][asset_managment][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>

                                            @endif
                                        @if(isset($permissions->certificate->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Certificate Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" id="checkbox"  data-id="certificate"   aria-label="Checkbox for following text input" <?php if(isset($staffpermission->certificate->status)=="1"){ echo 'checked'; } ?> name="role_per[certificate][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                </div>

                                            </div>

                                            @endif
                                        @if(isset($permissions->certificate->slc->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="SLC">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="certificate"  aria-label="Checkbox for following text input" <?php if(isset($staffpermission->certificate->slc->status)=="1"){ echo 'checked'; } ?> name="role_per[certificate][slc][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button"  class="certificate" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox"   class="certificate"name="role_per[certificate][slc][view]" class="hidden" <?php if(isset($staffpermission->certificate->slc->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"  class="certificate" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox"  class="certificate" class="hidden"  name="role_per[certificate][slc][create]" <?php if(isset($staffpermission->certificate->slc->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"  class="certificate" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox"   class="certificate"class="hidden"  name="role_per[certificate][slc][update]" <?php if(isset($staffpermission->certificate->slc->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"  class="certificate" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox"  class="certificate" class="hidden" <?php if(isset($staffpermission->certificate->slc->delete)=="1"){ echo 'checked'; } ?>  name="role_per[certificate][slc][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->certificate->experience->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Experience">
                                                                <div class="input-group-text">
                                                                <input type="checkbox"  class="certificate"aria-label="Checkbox for following text input" <?php if(isset($staffpermission->certificate->experience->status)=="1"){ echo 'checked'; } ?> name="role_per[certificate][experience][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button"  class="certificate"class="btn" data-color="primary">View</button>
                                                                <input type="checkbox"  class="certificate"name="role_per[certificate][experience][view]" class="hidden" <?php if(isset($staffpermission->certificate->experience->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"  class="certificate"class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="certificate" class="hidden"  name="role_per[certificate][experience][create]" <?php if(isset($staffpermission->certificate->experience->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"  class="certificate"class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="certificate" class="hidden"  name="role_per[certificate][experience][update]" <?php if(isset($staffpermission->certificate->experience->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="certificate" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="certificate" class="hidden" <?php if(isset($staffpermission->certificate->experience->delete)=="1"){ echo 'checked'; } ?>  name="role_per[certificate][experience][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                        @if(isset($permissions->certificate->curricular->status)=="1")
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Curricular ">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" class="certificate" aria-label="Checkbox for following text input" <?php if(isset($staffpermission->certificate->curricular->status)=="1"){ echo 'checked'; } ?> name="role_per[certificate][curricular][status]" value="1">
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="certificate" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" class="certificate" name="role_per[certificate][curricular][view]" class="hidden" <?php if(isset($staffpermission->certificate->curricular->view)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="certificate" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="certificate" class="hidden"  name="role_per[certificate][curricular][create]" <?php if(isset($staffpermission->certificate->curricular->create)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button"  class="certificate"class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="certificate" class="hidden"  name="role_per[certificate][curricular][update]" <?php if(isset($staffpermission->certificate->curricular->update)=="1"){ echo 'checked'; } ?> value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="certificate" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox"  class="certificate"class="hidden" <?php if(isset($staffpermission->certificate->curricular->delete)=="1"){ echo 'checked'; } ?>  name="role_per[certificate][curricular][delete]" value="1"/>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>

                                    @endif




                                </div>


                                <div class="row register-form">
                                    <div class="col-md-6">
                                        <input type="submit" value="Update Staff" id="btn_s" class="btn btn-primary btn-fluid waves-effect waves-light">
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    </div>
</div>


@endSection

@section("customscript")
<script>
// $(document).ready(function () {
//     function selectionFun(id) {
//         // if(this.checked) {
//         // $('#'+id).attr('disabled',true);
//         // }else{

//         // }
//     }
// });
$('body').on('change','#checkbox',function(){
    var id = $(this).data('id');
        if(this.checked) {
            $('.'+id).each(function () {
                $(this).prop('checked',true).prop('disabled',false);
                // alert($(this).html());
            });
        }else{
            $('.'+id).each(function () {
                    //   alert($(this).html());
                 $(this).prop('checked',false).attr('disabled',true);
            });

        }
});

$(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateisplay();
        });
        $checkbox.on('change', function () {
            updateisplay();
        });

        // Actions
        function updateisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});
</script>
<script>
    $(document).ready(function(){
        $("#city").select2();
    });

$('body').on('submit','#insertcampus',function(e){
      e.preventDefault();
      $('#username_error').text('');
      $('#password_error').text('');
      $('#email_error').text('');
      var formData = new FormData(this);
      $.ajax({
        url: '{{url("updatestaff")}}',
            type:'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                if(data){
                toastr.success('success updated staff', 'Notice');
                setTimeout(function(){location.reload();},1000);

                  }
                  else
                  {
                     toastr.error("Another Staff Already Existed with this Email",'Notice');
                  }
              },
            error: function(error){
                console.log(error);
                var response = $.parseJSON(error.responseText);
                    $.each(response.errors, function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
              }
      });

    });

  </script>

@endsection
