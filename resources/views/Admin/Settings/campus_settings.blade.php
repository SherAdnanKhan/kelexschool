@extends('Admin.layout.master')
@section("page-css")
  <!-- DataTables -->
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<style>
.center {
  display: flex;
  justify-content: center;
  align-items: center;
  border: 3px solid green;
  margin-bottom:5px;
  margin-left:400px; 
}

  </style>

@endsection
@section('content')
<div class="row">
   <div class="col-md-9 col-sm-12 col-lg-9">

      <div class="card m-b-30 card-body ">
      <form method="post" action="{{ route('update_campus_settings')}}" id="editcampus" enctype="multipart/form-data">
                                 <div class="row register-form">

                                    <div class="col-md-12">
                                      <h5> General Settings </h5>
                                        <div class="form-group">
                                            
                                            <input type="hidden" id="cid" class="form-control" name="CAMPUS_ID" placeholder="Enter Campus id *" value="{{$campus->CAMPUS_ID}}" />
                                        </div>
                                        <div class="form-group">
                                        <label for="">{{Session::get('campusname')}} Name*</label>
                                            <input type="text" id="sname" class="form-control" name="SCHOOL_NAME" placeholder="Enter School name *" value="{{$campus->SCHOOL_NAME}}" />
                                        </div>
                                        <div class="form-group">
                                        <label for="">{{Session::get('campusname')}} Address*</label>
                                            <input type="text" id="saddress" class="form-control" name="SCHOOL_ADDRESS" placeholder="Enter School Address *" value="{{$campus->SCHOOL_ADDRESS}}" />
                                        </div>
                                        <div class="form-group">
                                        <label for="">{{Session::get('campusname')}} Phone No*</label>
                                            <input type="text" id="pno" class="form-control"  name="PHONE_NO" placeholder="Enter Phone No *" value="{{$campus->PHONE_NO}}" />
                                        </div>
                                        <div class="form-group">
                                        <label for="">{{Session::get('campusname')}} Mobile No*</label>
                                            <input type="text" id="mno" class="form-control"  name="MOBILE_NO" placeholder="Enter Mobile No *" value="{{$campus->MOBILE_NO}}" />
                                        </div>
                                        <div class="form-group">
                                        <label for="">{{Session::get('campusname')}} Reg-No*</label>
                                            <input type="text" id="sreg" class="form-control"  name="SCHOOL_REG" placeholder="Enter School Registration *" value="{{$campus->SCHOOL_REG}}" />
                                        </div>
                                        <div class="form-group">
                                        <label for=""> Select Current/Default {{Session::get('session')}}</label>
                                        <select name="SESSION_ID" class="form-control formselect required" placeholder="Select Session" id="SESSION_ID">
                                      <option value="0" disabled selected>Select
                                      {{Session::get('session')}}*</option>
                                      @foreach($sessions as $session)
                                      <option  value="{{ $session->SB_ID }}" <?= $session->SB_ID==$campus->CURRENT_SESSION?'selected':''   ?>>
                                        {{ ucfirst($session->SB_NAME) }}</option>
                                      @endforeach
                                      </select>
                                       <small id="SESSION_ID_error" class="form-text text-danger"></small> 
                                      
                                      </div>
                                        <div class="form-group">
                                        <label for="myfile">Update {{Session::get('campusname')}} Logo:</label>
                                        <input type="file" id="myfile" name="LOGO_IMAGE">
                                        <img src="{{ asset('upload')}}/{{$campus->LOGO_IMAGE}}" alt="No image Found" style="width: 50px;height:50px;">
                                    <br><br>
                                        </div>
                                    </div>
                        <div class="form-group">
                        <input type="submit"value="Update Settings" class="btn btn-primary waves-effect waves-light center">
                          </div>
                      </div>
                           @csrf
                     </form>
      </div>
   </div>

</div>
 @endsection

 @section("customscript")
 <!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
 <!-- Required datatable js -->
 <script src="{{asset('admin_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <!-- Buttons examples -->
        <script src="{{asset('admin_assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/jszip.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/pdfmake.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/vfs_fonts.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/buttons.html5.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/buttons.print.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
<Script>
    $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$('body').on('submit','#editcampus',function (e) {
  e.preventDefault();
  var fdata = new FormData(this);
  $.ajax({
         url: '{{route("update_campus_settings")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
              if(data==true){
                  toastr.success(data.response,'Success');
                  setTimeout(function () {
                    location.reload();
                  },1000);
              }else{
                 toastr.error(data.response,'Error');
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
