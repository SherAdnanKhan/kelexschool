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
                                <a href='/showcampus' class="btn btn-primary">Show Existing Campus</a>
                            
                            </div>
                        </div>
                        <div class="card-body"> <h4 class="mt-0 header-title">Add Campus</h4>
                            <p class="text-muted m-b-30 ">Parsley is a javascript form validation
                            library. It helpsss you provide your users with feedback on their form
                            submission before sending it to your server.</p>

                            <h4 class="register-heading">Enter Campus Details</h4>
                        
                            <form method="post" action="{{ route('addcampus')}}" id="insertcampus" enctype="multipart/form-data">
                               @csrf
                                <div class="row register-form">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="Sname">School Name:</label> 
                                        <small id="schoolname_error" class="form-text text-danger"></small>
                                            <input type="text" class="form-control" name="schoolname" placeholder="Enter School name *" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="Saddress">School Address:</label> 
                                        <small id="schooladdress_error" class="form-text text-danger"></small>
                                            <input type="text" class="form-control" name="schooladdress" placeholder="Enter School Address *" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="pno">Phone No:</label> 
                                        <small id="phoneno_error" class="form-text text-danger"></small>
                                            <input type="text" class="form-control"  name="phoneno" placeholder="Enter Phone No *" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row register-form">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="Sname">Mobile No:</label> 
                                        <small id="mobileno_error" class="form-text text-danger"></small>
                                            <input type="text" class="form-control"  name="mobileno" placeholder="Enter Mobile No *" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="Sreg">School Reg:</label>
                                        <small id="schoolregistration_error" class="form-text text-danger"></small> 
                                            <input type="text" class="form-control"  name="schoolregistration" placeholder="Enter School Registration *" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="SEmail">Email</label> 
                                        <small id="schoolemail_error" class="form-text text-danger"></small>
                                            <input type="text" class="form-control"  name="schoolemail" placeholder="Enter School Website *" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row register-form">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="myfile">Upload School Logo:</label><br>
                                        <small id="schoollogo_error" class="form-text text-danger"></small>
                                                                    
                                        <input type="file" id="myfile" name="schoollogo"  accept="image/*"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Cid">City id:</label> 
                                            <small id="city_error" class="form-text text-danger"></small>
                                            <select name="city" id="city">
                                            @foreach($cities as $city)
                                            <option value="{{$city->city_id}}">{{$city->city_name}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Sins">Please Select Instuition type:</label><br> 
                                            <small id="instuition_error" class="form-text text-danger"></small>
                                            <label class="radio-inline">
                                            <input type="radio" name="instuition" value="school" style=" margin: 10px;" > School
                                            <input type="radio" name="instuition" value="L_instuition" style=" margin: 10px;"> Learning Instution
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row register-form">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Agt">Agreement:</label><br> 
                                            <small id="Aggreement_error" class="form-text text-danger"></small>
                                            <label class="radio-inline">
                                            <input type="radio" name="Aggreement" value="1"style=" margin: 10px;"> Yes
                                            <input type="radio" name="Aggreement" value="0"style=" margin: 10px;"> No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=agreement>  Agreement date</label>
                                            <small id="agreementdate_error" class="form-text text-danger"></small>
                                            <input type="date" class="form-control" name="agreementdate" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=agreement>  Enter Status:</label><br>
                                            <small id="status_error" class="form-text text-danger"></small>
                                            <label class="radio-inline">
                                            <input type="radio" name="status" value="1" style=" margin: 10px;"  checked> Active 
                                            <input type="radio" name="status" value="0" style=" margin: 10px;"> Not Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for=agreement>SMS</label><br>
                                            <small id="smsstatus_error" class="form-text text-danger"></small>
                                            <label class="radio-inline">
                                            <input type="radio" name="smsstatus" value="1"style=" margin: 10px;"> Allowed
                                            <input type="radio" name="smsstatus" value="0"style=" margin: 10px;" checked> Not Allowed
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Enter Billing Details</label>
                                            <small id="billingcharges_error" class="form-text text-danger"></small>
                                            <input type="number" class="form-control" name="billingcharges" placeholder="Enter charges *" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <label for="">Enter Discount</label>
                                            <small id="discount_error" class="form-text text-danger"></small>
                                            <input type="number" class="form-control" name="discount" placeholder="Enter Discount *" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Please Select Billing Date </label>
                                            <small id="billingdate_error" class="form-text text-danger"></small>
                                            <input type="date" class="form-control" name="billingdate" placeholder="Enter Agreement date *" value="" />
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
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group mb-6">
                                                        <div class="input-group-prepend">
                                                        <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="USER MANAGMENT">
                                                            <div class="input-group-text">
                                                            <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[usermanagment][status]" value="1">
                                                            </div>
                                                        </div>
                                                        
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <span class="button-checkbox">
                                                            <button type="button" class="btn" data-color="primary">View</button>
                                                            <input type="checkbox" name="role_per[usermanagment][view]" class="hidden" checked value="1" />
                                                        </span>
                                                        <span class="button-checkbox">
                                                            <button type="button" class="btn" data-color="success">Create</button>
                                                            <input type="checkbox" class="hidden"  name="role_per[usermanagment][create]" checked value="1" />
                                                        </span>
                                                        <span class="button-checkbox">
                                                            <button type="button" class="btn" data-color="info">Update</button>
                                                            <input type="checkbox" class="hidden"  name="role_per[usermanagment][update]" checked value="1" />
                                                        </span>
                                                        <span class="button-checkbox">
                                                            <button type="button" class="btn" data-color="warning"  name="role_per[usermanagment][delete]">Delete</button>
                                                            <input type="checkbox" class="hidden" checked value="1" />
                                                    </span>  
                                                </div>
                                            </div>
                                            </div> 
                                                <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Acadamics">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[acadamics][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="STUDENT MANAGAMENT">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[acadamics][student_manage]status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[acadamics][student_manage][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[acadamics][student_manage][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[acadamics][student_manage][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked name="role_per[acadamics][student_manage][delete]"  value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="SESSION / BATCH">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[acadamics][session][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[acadamics][session][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[acadamics][session][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[acadamics][session][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked name="role_per[acadamics][session][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="CLASSES / PROGRAM">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[acadamics][classess][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[acadamics][classess][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[acadamics][classess][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[acadamics][classess][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked name="role_per[acadamics][classess][delete]" value="1" />
                                                        </span>  
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="SECTION /SEMESTER">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[acadamics][sections][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[acadamics][sections][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[acadamics][sections][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[acadamics][sections][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked name="role_per[acadamics][sections][delete]" value="1" />
                                                        </span>  
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Subjects">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[acadamics][subjects][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[acadamics][subjects][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[acadamics][subjects][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[acadamics][subjects][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[acadamics][subjects][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Admission Withdraw">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[admissionwithdraw][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="With-Draw Register">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[admissionwithdraw][withdraw_register][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[admissionwithdraw][withdraw_register][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[admissionwithdraw][withdraw_register][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[admissionwithdraw][withdraw_register][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[admissionwithdraw][withdraw_register][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Register Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[registermanagment][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[registermanagment][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[registermanagment][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[registermanagment][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[registermanagment][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="correspondence">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[correspondence][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Complaint Letter Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[complaintletter][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[complaintletter][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[complaintletter][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[complaintletter][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[complaintletter][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Showcause Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[showcause][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[showcause][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[showcause][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[showcause][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[showcause][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Notification">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[notification][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[notification][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[notification][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[notification][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[notification][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Fee Managnent">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[fee_managament][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Define Fee Category">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[fee_managament][fee_category][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[fee_managament][fee_category][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[fee_managament][fee_category][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[fee_managament][fee_category][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[fee_managament][fee_category][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Define Fee">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[fee_managament][define_fee][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[fee_managament][define_fee][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[fee_managament][define_fee][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[fee_managament][define_fee][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[fee_managament][define_fee][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Fee Collection">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[fee_managament][fee_collection][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[fee_managament][fee_collection][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[fee_managament][fee_collection][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[fee_managament][fee_collection][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[fee_managament][fee_collection][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Print Fee Voucher">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[fee_managament][fee_voucher][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[fee_managament][fee_voucher][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[fee_managament][fee_voucher][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[fee_managament][fee_voucher][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[fee_managament][fee_voucher][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Fee register">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[fee_managament][fee_register][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[fee_managament][fee_register][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[fee_managament][fee_register][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[fee_managament][fee_register][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[fee_managament][fee_register][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Family Accounts">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[fee_managament][family_accounts][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[fee_managament][family_accounts][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[fee_managament][family_accounts][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[fee_managament][family_accounts][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[fee_managament][family_accounts][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Student Attendance">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[std_attendance][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Applications">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[std_attendance][application][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[std_attendance][application][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[std_attendance][application][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[std_attendance][application][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[std_attendance][application][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Attendance Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[std_attendance][std_attendance_manage][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[std_attendance][std_attendance_manage][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[std_attendance][std_attendance_manage][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[std_attendance][std_attendance_manage][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[std_attendance][std_attendance_manage][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Non-Present Report">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[std_attendance][non_present][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[std_attendance][non_present][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[std_attendance][non_present][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[std_attendance][non_present][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[std_attendance][non_present][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="HR Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[hr_managment][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Employee Categories">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[hr_managment][emp_categories][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[hr_managment][emp_categories][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[hr_managment][emp_categories][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[hr_managment][emp_categories][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[hr_managment][emp_categories][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Employee Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[hr_managment][emp_manage][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[hr_managment][emp_manage][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[hr_managment][emp_manage][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[hr_managment][emp_manage][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[hr_managment][emp_manage][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Employee Attendance">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[hr_managment][emp_attendance][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[hr_managment][emp_attendance][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[hr_managment][emp_attendance][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[hr_managment][emp_attendance][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[hr_managment][emp_attendance][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Accounts">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[accounts][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Assets Category">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[accounts][asset_category][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[accounts][asset_category][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[accounts][[asset_category][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[accounts][asset_category][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[accounts][asset_category][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Assets Managamnet">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[accounts][asset_managment][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[accounts][asset_managment][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[accounts][asset_managment][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[accounts][asset_managment][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[accounts][asset_managment][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Certificate Managment">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[certificate][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                        
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="SLC">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[certificate][slc][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[certificate][slc][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[certificate][slc][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[certificate][slc][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[certificate][slc][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Experience">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[certificate][experience][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[certificate][experience][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[certificate][experience][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[certificate][experience][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[certificate][experience][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <div class="input-group mb-6">
                                                            <div class="input-group-prepend">
                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" readonly value ="Curricular ">
                                                                <div class="input-group-text">
                                                                <input type="checkbox" aria-label="Checkbox for following text input" checked name="role_per[certificate][curricular][status]" value="1">
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="primary">View</button>
                                                                <input type="checkbox" name="role_per[certificate][curricular][view]" class="hidden" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="success">Create</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[certificate][curricular][create]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="info">Update</button>
                                                                <input type="checkbox" class="hidden"  name="role_per[certificate][curricular][update]" checked value="1" />
                                                            </span>
                                                            <span class="button-checkbox">
                                                                <button type="button" class="btn" data-color="warning"  >Delete</button>
                                                                <input type="checkbox" class="hidden" checked  name="role_per[certificate][curricular][delete]" value="1"/>
                                                        </span>  
                                                    </div>
                                                </div>
                                                
                                            </div>


                                            
                                                
                                </div>
                
                        
                                <div class="row register-form">
                                    <div class="col-md-6">
                                        <input type="submit" value="Save Campus" id="btn_s" class="btn btn-primary btn-fluid waves-effect waves-light"> 
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
      $('#schoolname_error').text('');
      $('#schooladdress_error').text('');
      $('#phoneno_error').text('');
      $('#mobileno_error').text('');
      $('#schoolregistration_error').text('');
      $('#schoolwebsite_error').text('');
      $('#schoollogo_error').text('');
      $('#city_error').text('');
      $('#instuition_error').text('');
      $('#Aggreement_error').text('');
      $('#agreementdate_error').text('');
      $('#status_error').text('');
      $('#mdsstatus_error').text('');
      $('#billingcharges_error').text('');
      $('#discount_error').text('');
      $('#billingdate_error').text('');
      $('#schoolemail_error').text('');
      var formData = new FormData(this);
      formData.append('key1', 'value1');
formData.append('key2', 'value2');

// Display the key/value pairs
for (var pair of formData.entries()) {
    console.log(pair[0]+ ', ' + pair[1]); 
}

      $.ajax({
        url: '{{url("addcampus")}}',
            type:'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                if(data.status==1){
                toastr.success('success added campus', 'Notice');
                setTimeout(function(){location.reload();},1000);
                }
                else{
                    toastr.error(data.response, 'Notice');
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