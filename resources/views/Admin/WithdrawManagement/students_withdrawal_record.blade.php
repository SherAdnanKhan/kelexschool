@extends('Admin.layout.master')
@section("page-css")
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
<link href="{{asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<style>


.rollbackbtn {background-color: #1c7430;
color:aliceblue;}
.rollbackbtn:hover {
  color: white;
  font-weight: bold;
} 
</style>
@endsection
@section("content")
<div class="row">
   <div class="col-md-12">
      <div class="card m-b-30 card-body">
          <div class="row">
          <div class="col-md-4">
          <div class="form-group">
          <small id="SESSION_ID_error" class="form-text text-danger"></small>
                 <label for="">{{Session::get('session')}} *<span class="gcolor"></span> </label>
                  <select class="form-control formselect required" placeholder="Select Session"
                    id="session_id">
                    <option value="">Select {{Session::get('session')}}</option>
                     @foreach($sessions as $row)
                        <option  value="{{ $row->SB_ID }}">{{ ucfirst($row->SB_NAME) }}</option>
                     @endforeach
                  </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="">{{Session::get('class')}} *<span class="gcolor"></span> </label>
                  <select class="form-control formselect required" placeholder="Select Class"
                    id="class_id">
                    <option value="0"  selected>Select
                    {{Session::get('class')}}*</option>
                    @foreach($classes as $class)
                    <option  value="{{ $class->Class_id }}">
                        {{ ucfirst($class->Class_name) }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
              <small id="SECTION_ID_error" class="form-text text-danger"></small>
                   <label>{{Session::get('section')}}*</label>
                  <select class="form-control formselect required" placeholder="Select Section" id="sectionid">
                    <option value="0"  selected>Select {{Session::get('section')}}
                  </select>
              </div>
            </div>
          
          </div>
      </div>
    </div>
  </div>
  <div class="row">
   <div class="col-md-12">
      <div class="card m-b-30 card-body">
          <div class="row">
            <div class="col-md-12" id="displaydata">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('customscript')
<script>  
</script>
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
        <script src="{{asset('admin_assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
<script>
    $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
        $(document).ready(function () {
          $('#session_id').on('change', function () {
          sessid = $(this).val();
          });
          $('#class_id').on('change', function () {
          cid = $(this).val();
          $('#sectionid').empty();
          $('#sectionid').append(`<option value="0" disabled selected>Processing...</option>`);
          $.ajax({
            type: 'GET',
            url: 'getsections/' + cid,
            success: function (response) {
            var response = JSON.parse(response);
            //console.log(response);   
            $('#sectionid').empty();
            $('#sectionid').append(`<option value="0" disabled selected>Select Section*</option>`);
            response.forEach(element => {
                $('#sectionid').append(`<option value="${element['Section_id']}.${element['Class_id']}">${element['Section_name']}</option>`);
                });
            }
          });
        });
        $('#sectionid').on('change', function () {
          sid = $(this).val();
          if (typeof sessid === 'undefined'){
              toastr.error('Please Select Session at first','Error');
              return false;
              }
                let html = "";
                $.ajax({
                type: 'POST',
                dataType: "json",
                data: {SECTION_ID:sid,SESSION_ID:sessid},
                url: 'getmatchingstudent/',
                success: function (data) {

                  if ($.trim(data) == '' ) {
                    html +='<p style="text-align:center;color:red;"> NO Result Match </p>';
                  }
                  else
                  {
                    html += ' <div class="table-responsive">';
                    html += '<table id="DataTables_Table_0" class="table table-bordered">';
                    html += '<thead>';
                    html += ' <tr>';
                    html += '   <th scope="col">Student ID</th>';
                    html += '    <th scope="col">Student Name</th>';
                    html += '   <th scope="col">FATHER NAME</th>';
                    html += '    <th scope="col">FATHER Contact</th>';
                    html += '    <th scope="col">PRESENT ADDRESS</th>';
                    html += '    <th scope="col">Student Picture</th>';
                    html += '     <th scope="col">Roll Back Student</th>';
                    html += '   </tr>';
                    html += ' </thead>';
                    html += ' <tbody>';
                    for (i = 0; i < data.length; i++) {
                     let image = (!data[i].IMAGE == "") ? '{{asset("upload")}}/{{Session::get("CAMPUS_ID")}}/'+data[i].IMAGE : 'https://via.placeholder.com/200';
                      html += '<tr id="row'+data[i].STUDENT_ID+'">';
                      html += '  <td>'+ data[i].STUDENT_ID+' </td>';
                      html += '  <td>' + data[i].NAME+ '</td>';
                      html += '  <td>' + data[i].FATHER_NAME+ '</td>';
                      html += '  <td>' + data[i].FATHER_CONTACT+ '</td>';
                      html += '  <td>' + data[i].PRESENT_ADDRESS + '</td>';
                      html += '  <td><img src="'+image+'" style="width:50px;height:50px;" alt=""></td>';
                      html += '   <td>';
                      html += '     <button value="" onclick="myFunction('+ data[i].STUDENT_ID+')" class="btn rollbackbtn">Roll Back</button>';
                      html += '   </td>';
                       html += '</tr>';
                    }
                    html += '</tbody>';
                   html += '</table>';
                   html += '</div>';

                  }
                  $("#displaydata").empty();
                $('#displaydata').html(html);
                $('#DataTables_Table_0').DataTable();
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
    });
  </script>
  <script>
function myFunction(studentid) {
  var r = confirm("Are you want to 'ROLLBACK' Student");
  if (r == true) {
   var STUDENT_ID = studentid;
   $(".rollbackbtn").prop('disabled', true); 
        $.ajax({
            url: '{{url("rollbackstudent")}}',
            type: "POST",
            data: {
              STUDENT_ID:STUDENT_ID
            }, 
            dataType:"json",
            success: function(data){
             // return false;
            
              toastr.success('successfully roll back', 'Notice');
              setTimeout(function(){location.reload();},1000);

            }
        });
  } else {
    toastr.error('Successfully Cancelled', 'Notice');
         }
}
</script>
@endsection