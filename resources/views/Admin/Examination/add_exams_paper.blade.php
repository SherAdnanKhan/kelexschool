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
          <div class="col-md-3">
              <div class="form-group">
               <form action="" id="searching" method="post">
                  @csrf
                <label for="">{{Session::get('session')}} *<span class="gcolor"></span> </label>
                  <select class="form-control formselect required" placeholder="Select Class"
                   name="SESSION_ID">
                    <option disabled  selected>Select
                    {{Session::get('session')}}*</option>
                    @foreach($sessions as $session)
                    <option  value="{{ $session->SB_ID }}">
                        {{ ucfirst($session->SB_NAME) }}</option>
                    @endforeach
                </select>
                <small id="SESSION_ID_error" class="form-text text-danger"></small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
            
                <label for="">{{Session::get('class')}} *<span class="gcolor"></span> </label>
                  <select class="form-control formselect required" placeholder="Select Class"
                  name="CLASS_ID" id="class_id">
                    <option disabled  selected>Select
                    {{Session::get('class')}}*</option>
                    @foreach($classes as $class)
                    <option  value="{{ $class->Class_id }}">
                        {{ ucfirst($class->Class_name) }}</option>
                    @endforeach
                </select>
                <small id="CLASS_ID_error" class="form-text text-danger"></small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
             
                   <label>{{Session::get('section')}}*</label>
                  <select class="form-control formselect required" placeholder="Select Section" name="SECTION_ID" id="sectionid">
                    <option disabled  selected>Select
                  </select>
              </div>
              <small id="SECTION_ID_error" class="form-text text-danger"></small>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                  <label for="">Search</label>
                  <div class="input-group">
                      <div class="input-group-append">
                      <input type="submit" value="Search" class="btn btn-large">
                  </form>
                     </div>
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

 <!-- Add Modal Start here                                             -->
   <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
                  <h5 class="modal-title mt-0" id="myLargeModalLabel">Add ExamPapers</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            <form method="post" action="{{ route('add_exam_paper')}}" id="add_exam_paper" enctype="multipart/form-data">
            @csrf
            <div class="row register-form">

                                    <div class="col-md-6">
                                    <div class="form-group">
                                       <input type="hidden" name="SESSION_ID" id="SESSION_ID1" value="">
                                       <input type="hidden" name="CLASS_ID" id="CLASS_ID1" value="">
                                       <input type="hidden" name="SECTION_ID" id="SECTION_ID1" value="">
                                          <label>Subject*</label>
                                       <select class="form-control formselect required" placeholder="Select Exam" name="SUBJECT_ID" >
                                       @foreach($subjects as $subject)
                                          <option  value="{{ $subject->SUBJECT_ID}}">
                                             {{ ucfirst($subject->SUBJECT_NAME) }}</option>
                                          @endforeach
                                       </select>
                                       <small id="SUBJECT_ID_error" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group">
                                    
                                    <p>Select Viva :</p>
                                        <label class="radio-inline">
                                          <input type="radio"  name="VIVA" value="1"> Yes
                                          <input type="radio"  name="VIVA" value="2"> No
                                        </label>
                                        <small id="VIVA_error" class="form-text text-danger"></small>
                                    </div>
                                    
                                    <div class="form-group">
                                    <label>Total Marks*</label>
                                            <input type="number" step="0.01"  class="form-control" name="TOTAL_MARKS" placeholder="Enter TOTAL MARKS *" value="" />
                                            <small id="TOTAL_MARKS_error" class="form-text text-danger"></small>
                                          </div>
                                    <div class="form-group">
                                    <label>Paper Time (Format 2 for hours . 30 for mints)*</label>
                                            <input type="float"  class="form-control" name="TIME" placeholder="Enter Paper TIME *" value="" />
                                            <small id="TIME_error" class="form-text text-danger"></small>
                                          </div>
                                     
                                
                                    </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                          <label>Exam*</label>
                                       <select class="form-control formselect required" placeholder="Select Exam" name="EXAM_ID" >
                                       @foreach($gexam as $exam)
                                          <option  value="{{ $exam->EXAM_ID}}">
                                             {{ ucfirst($exam->EXAM_NAME) }}</option>
                                          @endforeach
                                       </select>
                                       <small id="EXAM_ID_error" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group">
                                    
                                        <div class="form-group">
                                        <label>Viva Marks*</label>
                                            <input type="number"  class="form-control" name="VIVA_MARKS" placeholder="Enter VIVA MARKS *" value="" />
                                            <small id="VIVA_MARKS_error" class="form-text text-danger"></small>
                                          </div>
                                        <div class="form-group">
                                 <label>Passing Marks*</label>
                                    <input type="number" step="0.01" class="form-control" name="PASSING_MARKS" placeholder="Enter PASSING MARKS *" value="" />
                                    <small id="PASSING_MARKS_error" class="form-text text-danger"></small>
                                 </div>
                                 <label>Paper Date*</label>
                                            <input type="date"  class="form-control" name="DATE" placeholder="Enter Date *" value="" />
                                            <small id="DATE_error" class="form-text text-danger"></small>
                                          </div>
                                     
                                       
                                 
                                     </div>
                                </div>
                                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="editcampus">Save changes</button>
                     </div>
                           @csrf
                     </form>
            </div>
         </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
</div>

<!-- Edit Modal End here    -->
<div class="modal fade " id="editexam" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
                  <h5 class="modal-title mt-0" id="myLargeModalLabel">Add ExamPapers</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            <form method="post" action="{{ route('update_exam_paper')}}" id="update_exam_paper" enctype="multipart/form-data">
            @csrf
            <div class="row register-form">

                                    <div class="col-md-6">

                                    <div class="form-group">
                                    <input type="hidden" name="PAPER_ID" id="PAPER_ID" value="">
                                    <input type="hidden" name="SESSION_ID" id="SESSION_IDs" value="">
                                       <input type="hidden" name="CLASS_ID" id="CLASS_IDs" value="">
                                       <input type="hidden" name="SECTION_ID" id="SECTION_IDs" value="">
                                          <label>Subject*</label>
                                       <select class="form-control formselect required" placeholder="Select Exam" name="SUBJECT_ID" id="SUBJECT_ID">
                                       @foreach($subjects as $subject)
                                          <option  value="{{ $subject->SUBJECT_ID}}">
                                             {{ ucfirst($subject->SUBJECT_NAME) }}</option>
                                          @endforeach
                                       </select>
                                       <small id="SUBJECT_ID_err" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group">
                                    
                                    <p>Select Viva :</p>
                                        <label class="radio-inline">
                                          <input type="radio" id="agree1" name="VIVA" value="1"> Yes
                                          <input type="radio" id="agree0" name="VIVA" value="2"> No
                                        </label>
                                        <small id="VIVA_err" class="form-text text-danger"></small>
                                    </div>
                                    
                                    <div class="form-group">
                                    <label>Total Marks*</label>
                                            <input type="number" step="0.01" id="TOTAL_MARKS" class="form-control" name="TOTAL_MARKS" placeholder="Enter TOTAL MARKS *" value="" />
                                            <small id="TOTAL_MARKS_err" class="form-text text-danger"></small>
                                          </div>
                                    <div class="form-group">
                                    <label>Paper Time (Format 2 for hours . 30 for mints)*</label>
                                            <input type="float" id="TIME" class="form-control" name="TIME" placeholder="Enter Paper TIME *" value="" />
                                            <small id="TIME_err" class="form-text text-danger"></small>
                                          </div>
                                     
                                
                                    </div>
                                  <div class="col-md-6">
                               
                                    <div class="form-group">
                                          <label>Exam*</label>
                                       <select class="form-control formselect required" placeholder="Select Exam" name="EXAM_ID" id="EXAM_ID">
                                       @foreach($gexam as $exam)
                                          <option  value="{{ $exam->EXAM_ID}}">
                                             {{ ucfirst($exam->EXAM_NAME) }}</option>
                                          @endforeach
                                       </select>
                                       <small id="EXAM_ID_err" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group">
                                    <label>Paper Date*</label>
                                            <input type="date" id="DATE" class="form-control" name="DATE" placeholder="Enter Date *" value="" />
                                            <small id="DATE_err" class="form-text text-danger"></small>
                                          </div>
                                        <div class="form-group">
                                        <label>Viva Marks*</label>
                                            <input type="number" id="VIVA_MARKS" class="form-control" name="VIVA_MARKS" placeholder="Enter VIVA MARKS *" value="" />
                                            <small id="VIVA_MARKS_err" class="form-text text-danger"></small>
                                          </div>
                                        <div class="form-group">
                                 <label>Passing Marks*</label>
                                    <input type="number" step="0.01" id="PASSING_MARKS" class="form-control" name="PASSING_MARKS" placeholder="Enter PASSING MARKS *" value="" />
                                    <small id="PASSING_MARKS_err" class="form-text text-danger"></small>
                                 </div>
                                     
                                       
                                 
                                     </div>
                                </div>
                                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="editcampus">Save changes</button>
                     </div>
                           @csrf
                     </form>
            </div>
         </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
</div>

<!-- Edit Assinn teacher To Exam -->

<div id="assignteacher" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Assign Teacher For Marking</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">
                     <form action="{{route('assign_exam_paper')}}" id="assign" name="classform" method="post" accept-charset="utf-8">

                        <div class="box-body">
                           
                        <div class="form-group">
                           <input type="hidden" id='PAPER_IDs' name="PAPER_ID" value="">
                           <label>Select Teacher*</label>
                        <select class="form-control formselect required" placeholder="Select Exam" id="EMP_ID" name="EMP_ID">
                        @foreach($teachers as $teacher)
                           <option  value="{{ $teacher->EMP_ID}}">
                              {{ ucfirst($teacher->EMP_NAME) }}</option>
                           @endforeach
                        </select>
                        <small id="EMP_ID_error" class="form-text text-danger"></small>
                     </div>
                     <div class="form-group">
                     <label>Due Date*</label>
                              <input type="date" class="form-control" id="DUEDATE" name="DUEDATE" placeholder="Enter Date *" value="" />
                              <small id="DATE_err" class="form-text text-danger"></small>
                           </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                     </div>
                           @csrf
                     </form>

                  
                   
               </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
         </div><!-- /.modal -->
   </div>



 <!-- Edit class using modal -->
</div>
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
<script>
 $(document).ready( function () {
      $('#DataTables_Table_0').DataTable();
      });
      $(document).ready(function(){
    $('#class_id').on('change', function () {
                let id = $(this).val();
                class_id = id;
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
   $('body').on('submit','#searching',function(e){
   e.preventDefault();
   $('#SECTION_ID_error').text('');
   $('#CLASS_ID_error').text('');
   $('#SESSION_ID_error').text('');
   $('#displaydata').empty();  
   var fdata = new FormData(this);
    html="";
   $.ajax({
        url: '{{url("view_exam_paper")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
              var record= data.record;
               $('#SECTION_ID1').val(data.SECTION_ID);
               $('#CLASS_ID1').val(data.CLASS_ID);
               $('#SESSION_ID1').val(data.SESSION_ID);
               $('#SECTION_IDs').val(data.SECTION_ID);
               $('#CLASS_IDs').val(data.CLASS_ID);
               $('#SESSION_IDs').val(data.SESSION_ID);
            //console.log(data);
            // return false;
            if (record.length>0)
            { 
          html+='<small id="PAPER_IDs_err" class="form-text text-danger"></small>';
          html+='  <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg">Add New Paper</button>';
          html += ' <div class="table-responsive">';
                    html += '<table id="DataTables_Table_0" class="table table-bordered">';
                    html += '<thead>';
                    html += ' <tr>';
                    html += '   <th scope="col">Paper ID</th>';
                    html += '    <th scope="col">{{Session::get("session")}} Name</th>';
                    html += '    <th scope="col">{{Session::get("class")}} Name</th>';
                    html += '    <th scope="col">{{Session::get("Section")}} Name</th>';
                    html += '    <th scope="col">Exam Name</th>';
                    html += '   <th scope="col">Subject NAME</th>';
                    html += '    <th scope="col">Total Marks</th>';
                    html += '    <th scope="col">Passing Marks</th>';
                    html += '    <th scope="col">Date</th>';
                    html += '    <th scope="col">Duration</th>';
                    html += '     <th scope="col">Edit</th>';
                    html += '     <th scope="col">Assign Teacher</th>';
                    html += '   </tr>';
                    html += ' </thead>';
                    html += ' <tbody>';
                    for (i = 0; i < record.length; i++) {
                      html += '<tr id="row'+record[i].PAPER_ID+'">';
                      html += '  <td>'+ record[i].PAPER_ID+' </td>';
                      html += '  <td>'+ record[i].SB_NAME+' </td>';
                      html += '  <td>'+ record[i].Class_name+' </td>';
                      html += '  <td>'+ record[i].Section_name+' </td>';
                      html += '  <td>'+ record[i].EXAM_NAME+' </td>';
                      html += '  <td>' + record[i].SUBJECT_NAME+ '</td>';
                      html += '  <td>' + record[i].TOTAL_MARKS+ '</td>';
                      html += '  <td>' + record[i].PASSING_MARKS+ '</td>';
                      html += '  <td>' + record[i].DATE + '</td>';
                      html += '  <td>' + record[i].TIME + '</td>';
                      html += '  <td> <button class="btn btn-primary editbtn" value="' + record[i].PAPER_ID + '">Edit</button> '; 
                      html += '  <td> <button class="btn btn-secondary assignbtn" value="' + record[i].PAPER_ID + '">Assign</button> '; 
                      html += '   </td>';
                      html += '</tr>';
                    }
                    html += '</tbody>';
                   html += '</table>';
                   html += '</div>';
            }
            else
            {
            html+='  <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg">Add New Paper</button>';
            toastr.warning('No record found Add New', 'Notice');
            }
            $("#displaydata").empty();
            $('#displaydata').html(html);
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
$('body').on('submit','#add_exam_paper',function(e){
e.preventDefault();
$('#EXAM_ID_error').text('');
$('#SUBJECT_ID_error').text(''); 
$('#TIME_error').text('');
$('#DATE_error').text(''); 
$('#TOTAL_MARKS_error').text('');
$('#PASSING_MARKS_error').text('');
$('#VIVA_error').text('');
$('#VIVA_MARKS_error').text(''); 
   
var fdata = new FormData(this);
   $.ajax({
        url: '{{url("add_exam_paper")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
            //console.log(data);
            if(data==true){
                toastr.success('success added Paper', 'Notice');
                setTimeout(function(){location.reload();},1000);
                }
            else if(data=='subjectexist')
            {
               toastr.warning('Paper Already Added Please Refresh', 'Notice');
            }
            else if(data=='datematch')
            {
               toastr.warning('Already Paper Exist on Specifc Date', 'Notice');
            }
                else{
                    toastr.error('Date Doesnot Include in Exam Schedule', 'Notice');
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
   $('body').on('click', '.editbtn',function () {
        var PAPER_ID = $(this).val();
        $.ajax({
            url: '{{url("edit_exam_paper")}}',
            type: "GET",
            data: {
               PAPER_ID:PAPER_ID
            }, 
            dataType:"json",
            success: function(data){
              //console.log(data);
              
            $('#PAPER_ID').val(data['PAPER_ID']);
            $('#SUBJECT_ID').val(data["SUBJECT_ID"]).change();
            $('#TIME').val(data['TIME']);
            $('#DATE').val(data['DATE']);
            $('#TOTAL_MARKS').val(data['TOTAL_MARKS']);
            $('#PASSING_MARKS').val(data['PASSING_MARKS']);
            (data['VIVA']==1)?$('#agree1').prop('checked', true):$('#agree0').prop('checked', true);
            $('#VIVA_MARKS').val(data['VIVA_MARKS']);
            $('#EXAM_ID').val(data["EXAM_ID"]).change();
            }
        });
       $('#editexam').modal('show');
   });

$('body').on('submit','#update_exam_paper',function(e){
e.preventDefault();
$('#EXAM_ID_err').text('');
$('#SUBJECT_ID_err').text(''); 
$('#TIME_err').text('');
$('#DATE_err').text(''); 
$('#TOTAL_MARKS_err').text('');
$('#PASSING_MARKS_err').text('');
$('#VIVA_err').text('');
$('#VIVA_MARKS_err').text(''); 
var fdata = new FormData(this);
   $.ajax({
        url: '{{url("update_exam_paper")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
            //console.log(data);
            if(data==true){
                toastr.success('success updated Paper', 'Notice');
                setTimeout(function(){location.reload();},1000);
                }
            else if(data=='subjectexist')
            {
               toastr.warning('Paper Already Added Please Refresh', 'Notice');
            }
            else if(data=='datematch')
            {
               toastr.warning('Already Paper Exist on Specifc Date', 'Notice');
            }
                else{
                    toastr.error('Date Doesnot Include in Exam Schedule', 'Notice');
                }
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
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
   $('body').on('click', '.assignbtn',function () {
      $('#PAPER_ID_err').text('');
      $('#assign').get(0).reset();
      var PAPER_IDs = $(this).val();
      //alert(PAPER_IDs);
   $.ajax({
        url: '{{url("get_assign_exam_paper")}}',
            type:'POST',
            data:{PAPER_IDs:PAPER_IDs} ,
            // processData: false,
            // contentType: false,
            success: function(data){
            console.log(data);
            if(data!=null){
               $('#EMP_ID').val(data['EMP_ID']);
               $('#DUEDATE').val(data['DUEDATE']);
            }
             $('#PAPER_IDs').val(PAPER_IDs);

       $('#assignteacher').modal('show');
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
$('body').on('submit','#assign',function(e){
e.preventDefault();
$('#EMP_ID_error').text('');
$('#DUEDATE_error').text(''); 
var fdata = new FormData(this);
   $.ajax({
        url: '{{url("assign_exam_paper")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
            console.log(data);
            //return false;
            if(data==true){
                toastr.success('success added Paper', 'Notice');
                setTimeout(function(){location.reload();},1000);
                }
            else {
               toastr.warning('Already Paper Checked', 'Notice');
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
