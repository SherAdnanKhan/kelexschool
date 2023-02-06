@extends('Admin.layout.master')
@section("page-css")
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
<link href="{{asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section("content")
<div class="row">
   <div class="col-md-12">
      <div class="card m-b-30 card-body">
          <div class="row">
                <div class="col-md-2">
                <div class="form-group">
                    <form action="" id="searchpaper" method="post">
                        @csrf
                     <label for="">{{Session::get('session')}}</label>
                        <small class="req"> *</small>
                        <select name="SESSION_ID" class="form-control formselect required" placeholder="Select Session"
                           id="SESSION_ID">
                           <option value="0" disabled selected>Select
                           {{Session::get('session')}}*</option>
                           @foreach($sessions as $session)
                           <option  value="{{ $session->SB_ID }}">
                              {{ ucfirst($session->SB_NAME) }}</option>
                           @endforeach
                        </select>
                     <small id="SESSION_ID_error" class="form-text text-danger"></small>
                </div>
                </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="">{{Session::get('class')}} *<span class="gcolor"></span> </label>
                  <select class="form-control formselect required" placeholder="Select Class" name="CLASS_ID"
                    id="class_id">
                    <option value="0" disabled selected>Select
                    {{Session::get('class')}}*</option>
                    @foreach($classes as $class)
                    <option  value="{{ $class->Class_id }}">
                        {{ ucfirst($class->Class_name) }}</option>
                    @endforeach
                </select>
                <small id="CLASS_ID_err" class="form-text text-danger"></small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                   <label>{{Session::get('section')}}*</label>
                  <select class="form-control formselect required" placeholder="Select Section" name="SECTION_ID" id="sectionid">
                    <option value="0" disabled selected>Select {{Session::get('section')}}
                  </select>
                  <small id="SECTION_ID_err" class="form-text text-danger"></small>
              </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Exam*</label>
                <select class="form-control formselect required" placeholder="Select Exam" name="EXAM_ID" id="EXAM_ID">
                <option value="0" disabled selected>Select
                              Exam*</option>
               
                @foreach($gexam as $exam)
                    <option  value="{{ $exam->EXAM_ID}}">
                        {{ ucfirst($exam->EXAM_NAME) }}</option>
                @endforeach
                </select>
                <small id="EXAM_ID_err" class="form-text text-danger"></small>
            </div>
                </div>
                <div class="col-md-2">
              <div class="form-group">
                   <label>Subject*</label>
                  <select class="form-control formselect required" placeholder="Select Subject" name="SUBJECT_ID" id="SUBJECT_ID">
                    <option value="0" disabled selected>Select
                  </select>
                  <small id="SUBJECT_ID_err" class="form-text text-danger"></small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                  <label for="">Search</label>
                  <div class="input-group">
                      <input type="submit" value="Search" class="btn btn-primary ">
                      </form>
                  </div>
                 
                 
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
        $(document).ready(function () {
          $('#class_id').on('change', function () {
          let id = $(this).val();
          $('#sectionid').empty();
          $('#sectionid').append(`<option value="0" disabled selected>Processing...</option>`);
          $.ajax({
            type: 'GET',
            url: 'getsections/' + id,
            success: function (response) {
            var response = JSON.parse(response);
            //console.log(response);   
            $('#sectionid').empty();
            $('#sectionid').append(`<option value="0" disabled selected>Select Section*</option>`);
            response.forEach(element => {
                $('#sectionid').append(`<option value="${element['Section_id']}">${element['Section_name']}</option>`);
                });
            }
          });
        });
    });
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

    $('body').on('change','#EXAM_ID',function(){
        var exam_id = $(this).val();
        var SESSION_ID = $('#SESSION_ID').val();
        var CLASS_ID = $('#class_id').val();
        var SECTION_ID = $('#sectionid').val();
        $.ajax({
        url: '{{url("teacher/getsubjects")}}',
            type:'POST',
            data :{EXAM_ID:exam_id,SESSION_ID:SESSION_ID,CLASS_ID:CLASS_ID,SECTION_ID:SECTION_ID},
            // processData: false,
            // contentType: false,
            success: function(data){
                console.log(data);
                if ($.trim(data) !== '' ) {
              section_idd=data[0]['SECTION_ID'];
              session_idd=data[0]['SESSION_ID'];
              class_idd=data[0]['CLASS_ID'];
              exam_idd=data[0]['EXAM_ID'];
              paper_idd=data[0]['PAPER_ID'];
                }
            $('#SUBJECT_ID').empty();
            $('#SUBJECT_ID').append(`<option value="0" disabled selected>Select Subject*</option>`);
            data.forEach(element => {
                $('#SUBJECT_ID').append(`<option value="${element['SUBJECT_ID']}">${element['SUBJECT_NAME']}</option>`);
                });
            },
        });
    });


    $('body').on('change','#SUBJECT_ID',function(){
        var SUBJECT_ID = $(this).val();
        var EXAM_ID = $('#EXAM_ID').val();
        var SESSION_ID = $('#SESSION_ID').val();
        var CLASS_ID = $('#class_id').val();
        var SECTION_ID = $('#sectionid').val();
        $.ajax({
        url: '{{url("teacher/getpaperid")}}',
            type:'POST',
            data :{EXAM_ID:EXAM_ID,SUBJECT_ID:SUBJECT_ID,SESSION_ID:SESSION_ID,CLASS_ID:CLASS_ID,SECTION_ID:SECTION_ID},
            // processData: false,
            // contentType: false,
            success: function(data){
                console.log(data['DATE']);
              paper_idd=data['PAPER_ID'];
              paper_date=data['DATE'];
              //console.log(paper_idd);
            },
        });
    });
  $('body').on('submit','#searchpaper',function(e){
   e.preventDefault();
   $('#SECTION_ID_err').text('');
   $('#CLASS_ID_err').text('');
   $('#SESSION_ID_err').text('');
   $('#SUBJECT_ID_err').text('');
   $('#EXAM_ID_err').text('');
   $('#displaydata').empty(); 
   var fdata = new FormData(this);
    html="";
   $.ajax({
        url: '{{url("teacher/Search_attendance")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
             var subject_idd=data.subjectid;
             var data=data.result;

             //console.log(data);
             console.log(paper_idd);
             
             //return false;
                if ($.trim(data) == '' ) {
                    html +='<p style="text-align:center;color:red;"> NO Result Match </p>';
                  }
                  else
                  {

                    html += '<form action="" id="check_attendance" method="post">';
                    html += ' <div class="table-responsive">';
                    html += '<table class="table table-bordered">';
                    html += '<thead>';
                    html += ' <tr>';
                    html += '   <th scope="col">Student Reg-No</th>';
                    html += '    <th scope="col">Student Name</th>';
                    html += '   <th scope="col">FATHER NAME</th>';
                    html += '    <th scope="col"> Attendance Status</th>';
                    html += '    <th scope="col">Remarks</th>';
                    html += '   </tr>';
                    html += ' </thead>';
                    html += ' <tbody>';
                    html+=' <input type="hidden" name="SECTION_ID" value="'+section_idd+'">'
                    html+=' <input type="hidden" name="CLASS_ID" value="'+class_idd+'">'
                    html+=' <input type="hidden" name="SESSION_ID" value="'+session_idd+'">'
                    html+=' <input type="hidden" name="PAPER_ID" value="'+paper_idd+'">'
                    html+=' <input type="hidden" name="EXAM_ID" value="'+exam_idd+'">'
                    html+=' <input type="hidden" name="SUBJECT_ID" value="'+subject_idd+'">'
                    html+=' <input type="hidden" name="ATTEN_DATE" value="'+paper_date+'">'
                    for (i = 0; i < data.length; i++) 
                    {
                      var ATTEN_STATUS = typeof data[i].ATTEN_STATUS=='undefined' ? '' : data[i].ATTEN_STATUS;
                     // console.log(ATTEN_STATUS);
                      var Present = ATTEN_STATUS=='P' ? 'checked' : '';
                      var Absent = ATTEN_STATUS=='A' ? 'checked' : '';
                      var Leave = ATTEN_STATUS=='L' ? 'checked' : '';
                      var remarks = typeof data[i].REMARKS=='undefined'||data[i].REMARKS==null ? '' : data[i].REMARKS;
                      html += '<tr id="row'+data[i].STUDENT_ID+'">';
                      html += '  <td>'+ data[i].REG_NO+' </td>';
                      html += '  <td>' + data[i].NAME+ '</td>';
                      html += '  <td>' + data[i].FATHER_NAME+ '</td>';
                      html +='<td> <input type="hidden" id="STD_ID" name="STD_ID[]" value="'+data[i].STUDENT_ID+'">';
                      html += ' <input type="radio" '+Present+' id="present" name="ATTEN_STATUS['+i+']" value="P"> ';
                      html += ' <label for="Present">Present</label> ';
                      html += ' <input type="radio" '+Absent+' id="absent" name="ATTEN_STATUS['+i+']" value="A"> ';
                      html += ' <label for="Absent">Absent</label>'; 
                      html += ' <input type="radio" '+Leave+' id="leave" name="ATTEN_STATUS['+i+']" value="L"> ';
                      html += ' <label for="leave">Leave</label> ';
                      html += '</td>';
                    html += '  <td> <input type="textarea" name="REMARKS['+i+']" value="'+remarks+'" > </td>';
                    html +="</tr>";  
                }
                    html += '</tbody>';
                   html += '</table>';
                   html += '<input type="submit" class="btn pull-right btn-primary submitbtn">';
                    html += '</form>';
                   html += '</div>';

                  }
                  $("#displaydata").empty();
                $('#displaydata').html(html);
            },
            error: function(error){

               console.log(error);
               var response = $.parseJSON(error.responseText);
                    $.each(response.errors, function (key, val) {
                        $("#" + key + "_err").text(val[0]);
                    });
    }

   });
   });

 $('body').on('submit','#check_attendance',function(e){
   e.preventDefault();
   $(".submitbtn").prop('disabled', true); 

      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("teacher/Add_attendance")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            dataType:"json",
            success: function(data){
              //return false;
              $(".submitbtn").prop('disabled', false); 
              if(data){
                toastr.success('Action Performed Successfully','Notice')
                setTimeout(function(){location.reload();},1000);
              }
              else
              { 
                toastr.warning('Already Action taken, Please Refresh Page','Notice')
              }
            }
        });
   });
   
  </script>
@endsection