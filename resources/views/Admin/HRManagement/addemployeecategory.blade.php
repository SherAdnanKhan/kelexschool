@extends('Admin.layout.master')
@section('content')
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="card m-b-20">
                  <div class="row">
                     <div class="col-2">
                          <a href="{{route('showemployee')}}" class="btn btn-info">Show Existing Employee</a>
                        
                     </div>
                  </div>
                  <div class="card-body"> <h4 class="register-heading">Employee Details</h4>
                     <p class="text-muted m-b-30 ">Please fill all the mandaortey fields .</p>
                     <!-- student form start -->
                        <form id="addemployee" action="{{route('addemployee')}}"  method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        @csrf
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="upload">Upload EMPLOYEE picture</label>
                                    <input type="file" name="EMP_IMAGE" id="EMP_IMAGE" size="20" class="dropify"  accept="image/*"/>
                                    <small id="EMP_IMAGE_error" class="form-text text-danger"></small>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInputNAME1">Employee Name </label> 
                                       <small class="req"> *</small>
                                       <input id="EMP_NAME" name="EMP_NAME" placeholder="" type="text" class="form-control">
                                       <small id="EMP_NAME_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInpUTFNAME1">FATHER NAME</label>
                                       <small class="req"> *</small>
                                       <input id="FATHER_NAME" name="FATHER_NAME" placeholder="" type="text" class="form-control">
                                       <small id="FATHER_NAME_error" class="form-text text-danger"></small> 
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputFNO1">DESIGNATION ID</label>
                                          <small class="req"> *</small>
                                          <input id="DESIGNATION_ID" name="DESIGNATION_ID" placeholder="" type="number" class="form-control" >
                                          <small id="DESIGNATION_ID_error" class="form-text text-danger"></small>
                                       </div>
                                 </div>
                                </div>
                              <div class="row">
                                 <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputFSNO1">QUALIFICATION</label>
                                          <small class="req"> *</small>
                                          <input id="QUALIFICATION" name="QUALIFICATION" placeholder="" type="text" class="form-control" >
                                          <small id="QUALIFICATION_error" class="form-text text-danger"></small>
                                       </div>
                                 </div>
                             
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInputGen"> Gender</label>
                                       <small class="req"> *</small>
                                       <select class="form-control" name="GENDER">
                                          <option value="">Select</option>
                                          <option value="Male">Male</option>
                                          <option value="Female" selected="">Female</option>
                                       </select>
                                       <small id="GENDER_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInputdob1">Date of Birth</label>
                                       <small class="req"> *</small>
                                       <input id="EMP_DOB" name="EMP_DOB" placeholder="" type="date" class="form-control date">
                                       <small id="EMP_DOB_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>

                                 <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputFNO1">CNIC</label>
                                          <small class="req"> *</small>
                                          <input id="CNIC" name="CNIC" placeholder="" type="text" class="form-control" >
                                          <small id="CNIC_error" class="form-text text-danger"></small>
                                       </div>
                                 </div>
                                 </div>
                              <div class="row">

                                 <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputFNO1">ALLOWANCESS</label>
                                          <small class="req"> *</small>
                                          <input id="ALLOWANCESS" name="ALLOWANCESS" placeholder="" type="text" class="form-control" >
                                          <small id="ALLOWANCESS_error" class="form-text text-danger"></small>
                                       </div>
                                 </div>
                             
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="Sins"> EMPLOYEE TYPE:</label>
                                       <small class="req"> *</small>
                                       <label class="radio-inline">
                                       <input  type="radio" id="teaching" name="EMP_TYPE" value="1" style=" margin: 10px;"  > teaching staff
                                       <input type="radio" id="non-teaching" name="EMP_TYPE" value="2" style=" margin: 10px;"> non-teaching
                                       </label>
                                       <small id="EMP_TYPE_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInputPAl1">Employee NO</label>
                                       <small class="req"> *</small>
                                       <input type="number" id="EMP_NO" name="EMP_NO" class="form-control" >
                                       <small id="EMP_NO_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInputPAl1">EMPLOYEE ADDRESS</label>
                                       <small class="req"> *</small>
                                       <input type="text" id="ADDRESS" name="ADDRESS" class="form-control" >
                                       <small id="ADDRESS_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                
                              </div>
                              <div class="row">
                                 
                                 <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="exampleInputdob1">JOINING DATE</label>
                                       <small class="req"> *</small>
                                       <input id="JOINING_DATE" name="JOINING_DATE" placeholder="" type="date" class="form-control date">
                                       <small id="JOINING_DATE_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                    <div class="col-md-4"> 
                                    <div class="form-group">
                                    <label for="exampleInputdob1">LEAVING DATE</label>
                                       <small class="req"> *</small>
                                       <input id="LEAVING_DATE" name="LEAVING_DATE" placeholder="" type="date" class="form-control date">
                                       <small id="LEAVING_DATE_error" class="form-text text-danger"></small>
                                    </div>
                                   
                                 </div>
                                
                              </div>  
                              
                              <div class="box-footer text-center">
                                 
                                    <div class=" ">
                                       <button type="submit" class="btn btn-info btn-rounded align-items-right waves-effect waves-light">Save Employee</button>
                                    </div>
                              </div>
                        </form>
                     <!-- student form end -->
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
        

@endsection
@section("customscript")
<script>

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
                
$('body').on('submit','#addemployee',function(e){
      e.preventDefault();
      $('#EMP_NAME_error').text('');
      $('#FATHER_NAME_error').text('');
      $('#DESIGNATION_ID_error').text('');
      $('#QUALIFICATION_error').text('');
      $('#EMP_TYPE_error').text('');
      $('#ADDRESS_error').text('');
      $('#PASSWORD_error').text('');
      $('#EMP_IMAGE_error').text('');
      $('#JOINING_DATE_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("addemployee")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               console.log(data)
               toastr.success(data,'Notice');
               $("#addemployee").get(0).reset();
              },
              error: function(error){
               console.log(error);
               toastr.error('Please Fill the Required Fields','Notice');
               var response = $.parseJSON(error.responseText);
                    $.each(response.errors, function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
    }
      

              
      });
    });
</script>
@endsection