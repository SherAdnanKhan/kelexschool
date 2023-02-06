@extends('Admin.layout.master')
@section("page-css")
  <!-- DataTables -->
  <link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section("content")
<div class="row">
  <div class="col-md-2"></div>
   <div class="col-md-8">
      <div class="card m-b-30 card-body">
         <h3 class="card-title font-16 mt-0 text-center">Teacher Application Leave Form</h3>
         <form  action="{{ route('Teacher_Add_Application')}}" id="AddApplication" method="post" accept-charset="utf-8">
            <div class="box-body">
              @csrf   
              <div class="form-group">
                        <label for="">Type</label> 
                           <small class="req"> *</small>
                           <select name="APPLICATION_TYPE" class="form-control category_id required" placeholder="Select Category">
                              <option value="0" disabled selected>
                                Select Application Type *</option>
                              <option  value="1"> Sick Leave </option>
                              <option  value="2"> Leave </option>
                              <!-- <option  value="3"> Sick Leave </option>
                              <option  value="4"> Sick Leave </option> -->
                        </select>
                        <small id="APPLICATION_TYPE_error" class="form-text text-danger"></small>
                </div>                    
               <div class="form-group"><br>
                  <label for="exampleInputEmail1">From date</label>
                  <small id="START_DATE_error" class="form-text text-danger"></small>
                  <input name="START_DATE" placeholder="" id="txtDate" type="date" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="exampleInputEmail1">TO Date</label>
                  <small id="END_DATE_error" class="form-text text-danger"></small>
                  <input  name="END_DATE" placeholder="" id="txtDate1" type="date" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="m-t-20">
                <label class="text-muted">Application description</label>
                <small id="APPLICATION_DESCRIPTION_error" class="form-text text-danger"></small>
                <textarea name="APPLICATION_DESCRIPTION" class="form-control" maxlength="1000" rows="7" placeholder="This textarea has a limit of 1000 chars."></textarea>
                </div>
            </div><br>
            <div class="box-footer">
               <button type="submit" class="btn btn-info btn-rounded btn-block waves-effect waves-light">Save</button>
            </div>
         </form>
      </div>
   </div>

@endsection
@section("customscript")
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

$(document).ready(function() {

    var dtToday = new Date();
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();
    var maxDate = year + '-' + month + '-' + day;
    $('#txtDate').attr('min', maxDate);
    $('#txtDate1').attr('min', maxDate);
});
	  
$('body').on('submit','#AddApplication',function(e){
      e.preventDefault();
      $('#APPLICATION_TYPE_error').text('');
      $('#START_DATE_error').text('');
      $('#END_DATE_error').text('');
      $('#APPLICATION_DESCRIPTION_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("teacher/AddApplication")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
              if(data){
                toastr.success('Application Submitted Succcessfully');
                setTimeout(function(){location.reload();},1000);
            $("#AddApplication").get(0).reset();
              }
              else
              {
                  toastr.error('You have Already Submitted Application For Paticular date');
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