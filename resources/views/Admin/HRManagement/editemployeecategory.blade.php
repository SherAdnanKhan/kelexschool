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
                  <div class="card-body"> <h4 class="register-heading">Edit Employee Details</h4>
                     <p class="text-muted m-b-30 ">Please fill all the mandatory fields .</p>
                     <!-- student form start -->
                     <form id="updateemployee" action="{{route('updateemployee')}}"  method="post" accept-charset="utf-8" enctype="multipart/form-data">
                           @csrf
                                 <div class="row">
                                   <div class="col-md-3">
                                      <input type="hidden" name="EMP_ID" value="{{$employee['EMP_ID']}}" id="id">
                                       <label for="upload">Upload EMPLOYEE picture</label>
                                       <input type="file" name="EMP_IMAGE" id="EMP_IMAGE" size="20" class="dropify"  accept="image/*"/>
                                       <small id="EMP_IMAGE_error" class="form-text text-danger"></small>
                                       <img src="{{asset('upload/employee')}}{{Session::get('CAMPUS_ID')}}/{{$employee['EMP_IMAGE']}}" onerror="this.src='https://via.placeholder.com/200'" alt="" style="width: 50px;height:50px;">
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputNAME1">Employee Name </label> 
                                          <small class="req"> *</small>
                                          <input id="EMP_NAME" name="EMP_NAME" placeholder="" value="{{$employee['EMP_NAME']}}" type="text" class="form-control">
                                          <small id="EMP_NAME_error" class="form-text text-danger"></small>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInpUTFNAME1">FATHER NAME</label>
                                          <small class="req"> *</small>
                                          <input id="FATHER_NAME" name="FATHER_NAME" placeholder="" value="{{$employee['FATHER_NAME']}}"  type="text" class="form-control">
                                          <small id="FATHER_NAME_error" class="form-text text-danger"></small> 
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                          <div class="form-group">
                                             <label for="exampleInputFNO1">DESIGNATION ID</label>
                                             <small class="req"> *</small>
                                             <input id="DESIGNATION_ID" name="DESIGNATION_ID" placeholder="" value="{{$employee['DESIGNATION_ID']}}"  type="number" class="form-control" >
                                             <small id="DESIGNATION_ID_error" class="form-text text-danger"></small>
                                          </div>
                                    </div>
                                   </div>
                                 <div class="row">
                                    <div class="col-md-3">
                                          <div class="form-group">
                                             <label for="exampleInputFSNO1">QUALIFICATION</label>
                                             <small class="req"> *</small>
                                             <input id="QUALIFICATION" name="QUALIFICATION" placeholder="" value="{{$employee['QUALIFICATION']}}"  type="text" class="form-control" >
                                             <small id="QUALIFICATION_error" class="form-text text-danger"></small>
                                          </div>
                                    </div>
                                
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputGen"> Gender</label>
                                          <small class="req"> *</small>
                                          <select class="form-control" name="GENDER">
                                             <option value="">Select</option>
                                             <option value="Male" <?= $employee['GENDER']=='Male' ? 'selected':''?>>Male</option>
                                             <option value="Female"  <?=$employee['GENDER']=='Female' ? 'selected':''?>>Female</option>
                                          </select>
                                          <small id="GENDER_error" class="form-text text-danger"></small>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputdob1">Date of Birth</label>
                                          <small class="req"> *</small>
                                          <input id="EMP_DOB" name="EMP_DOB" placeholder="" value="{{date('Y-m-d',strtotime($employee['EMP_DOB']))}}"  type="date" class="form-control date">
                                          <small id="EMP_DOB_error" class="form-text text-danger"></small>
                                       </div>
                                    </div>
   
                                    <div class="col-md-3">
                                          <div class="form-group">
                                             <label for="exampleInputFNO1">CNIC</label>
                                             <small class="req"> *</small>
                                             <input id="CNIC" name="CNIC" placeholder=""value="{{$employee['CNIC']}}"  type="text" class="form-control" >
                                             <small id="CNIC_error" class="form-text text-danger"></small>
                                          </div>
                                    </div>
                                    </div>
                                 <div class="row">
   
                                    <div class="col-md-3">
                                          <div class="form-group">
                                             <label for="exampleInputFNO1">ALLOWANCESS</label>
                                             <small class="req"> *</small>
                                             <input id="ALLOWANCESS" name="ALLOWANCESS" placeholder="" value="{{$employee['ALLOWANCESS']}}"  type="text" class="form-control" >
                                             <small id="ALLOWANCESS_error" class="form-text text-danger"></small>
                                          </div>
                                    </div>
                                    <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInputPAl1">Employee NO</label>
                                       <small class="req"> *</small>
                                       <input type="number" id="EMP_NO" name="EMP_NO" value="{{$employee['EMP_NO']}}"  class="form-control" >
                                       <small id="EMP_NO_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="Sins"> EMPLOYEE TYPE:</label>
                                          <small class="req"> *</small>
                                          <label class="radio-inline">
                                          <input  type="radio" id="teaching" name="EMP_TYPE" <?= $employee['EMP_TYPE']=='1' ? 'checked':'' ?> value="1" style=" margin: 10px;"  > teaching staff
                                          <input type="radio" id="non-teaching" name="EMP_TYPE" <?= $employee['EMP_TYPE']=='2' ? 'checked':'' ?> value="2" style=" margin: 10px;"> non-teaching
                                          </label>
                                          <small id="EMP_TYPE_error" class="form-text text-danger"></small>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputPAl1">EMPLOYEE ADDRESS</label>
                                          <small class="req"> *</small>
                                          <input type="text" id="ADDRESS" value="{{$employee['ADDRESS']}}"  name="ADDRESS" class="form-control" >
                                          <small id="ADDRESS_error" class="form-text text-danger"></small>
                                       </div>
                                    </div>
                                   
                                 </div>
                                 <div class="row">
                                    
                                    <div class="col-md-4">
                                       <div class="form-group">
                                       <label for="exampleInputdob1">JOINING DATE</label>
                                          <small class="req"> *</small>
                                          <input id="JOINING_DATE" name="JOINING_DATE" placeholder="" value="{{date('Y-m-d',strtotime($employee['JOINING_DATE']))}}"  type="date" class="form-control date">
                                          <small id="JOINING_DATE_error" class="form-text text-danger"></small>
                                       </div>
                                    </div>
                                       <div class="col-md-4"> 
                                       <div class="form-group">
                                       <label for="exampleInputdob1">LEAVING DATE</label>
                                          <small class="req"> *</small>
                                          <input id="LEAVING_DATE" name="LEAVING_DATE" placeholder="" value="{{date('Y-m-d',strtotime($employee['LEAVING_DATE']))}}"  type="date" class="form-control date">
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
                
$('body').on('submit','#updateemployee',function(e){
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
        url: '{{url("updateemployee")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
              // return false;
               console.log(data)
               toastr.success(data,'Notice');
               $("#updateemployee").get(0).reset();
               setTimeout(function(){location.reload();},2000);
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