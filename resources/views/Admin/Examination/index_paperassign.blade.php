@extends('Admin.layout.master')
@section("page-css")
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
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
                    <form action="" id="ap_tr" method="post">
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
            <div class="col-md-3">
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
                <small id="CLASS_ID_error" class="form-text text-danger"></small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                   <label>{{Session::get('section')}}*</label>
                  <select class="form-control formselect required" placeholder="Select Section" name="SECTION_ID" id="sectionid">
                    <option value="0" disabled selected>Select
                  </select>
                  <small id="SECTION_ID_error" class="form-text text-danger"></small>
              </div>
            </div>
            <div class="col-md-3">
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
                <small id="EXAM_ID_error" class="form-text text-danger"></small>
            </div>
                </div>
          </div>
          <div class="row">
                <div class="col-md-3">
              <div class="form-group">
                   <label>Subject*</label>
                  <select class="form-control formselect required" placeholder="Select Subject" name="SUBJECT_ID" id="SUBJECT_ID">
                    <option value="0" disabled selected>Select
                  </select>
                  <small id="SUBJECT_ID_error" class="form-text text-danger"></small>
              </div>
            </div>
            <div class="col-md-3">
            <div class="form-group">
                           <label>Select Teacher*</label>
                     <select data-placeholder="Begin typing a name to filter..." multiple class=" form-control chosen-select" id="EMP_ID" name="EMP_ID[]">
                        @foreach($teachers as $teacher)
                           <option  value="{{ $teacher->EMP_ID}}">
                              {{ ucfirst($teacher->EMP_NAME) }}</option>
                           @endforeach
                        </select>
                        <small id="EMP_ID_error" class="form-text text-danger"></small>
             </div>
            </div>
            <div class="col-md-3">
            <div class="form-group">
                     <label>Due Date*</label>
                              <input type="date" class="form-control" id="DUEDATE" name="DUEDATE" placeholder="Enter Date *" value="" />
                              <small id="DUEDATE_error" class="form-text text-danger"></small>
             </div>
            </div>
                      
            <div class="col-md-3">
              <div class="form-group">
                  <label for="">Search</label>
                  <div class="input-group">
                      <input type="submit" value="Assign Teacher" class="btn btn-primary ">
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
                    <h3 style="margin-left:20px"> PAPER LOG</h3>
                </div>
            <div class="row">
            <div class="col-md-12">
            <table id="DataTables_Table_0" class="table table-striped table-bordered table-hover " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                      <tr>
                        <th scope="col">{{Session::get('session')}}</th>
                        <th scope="col">{{Session::get('class')}}</th>
                        <th scope="col">{{Session::get('section')}}</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Teacher</th>
                        <th scope="col">Upload Status</th>
                        <th scope="col">File</th>
                        <th scope="col">Due Date</th>
                      </tr>
                    </thead>
                    <tbody id="displaydata">
                        @if(isset($papers))
                      @foreach($papers as $paper)
                      <tr id="row{{$paper->PAPER_MARKING_ID}}">
                      <td>{{$paper->SB_NAME}}</td>
                      <td>{{$paper->Class_name}}</td>
                      <td>{{$paper->Section_name}}</td>
                      <td>{{$paper->SUBJECT_NAME}}</td>
                      <td>{{$paper->EMP_NAME}}</td>
                      <td><?= $paper->UPLOADSTATUS==1?'Pending':'Uploaded'?></td>
                      <?php if($paper->UPLOADSTATUS==2)
                      { 
                        $ext = pathinfo($paper->UPLOADFILE, PATHINFO_EXTENSION);
                       ?>
                     <td><a href="/downloadupload/{{$paper->UPLOADFILE}}"> <?php if($ext=='pdf'){ ?><i class="far fa-file-pdf" title="Download" style="font-size:48px;color:red"></i> <?php } else { ?>
                      <i class="fas fa-file-word" title="Download" style="font-size:48px;color:red"></i>
                   <?php  } ?>
                     </a>   </td>
                      <?php 
                       } 
                       else
                       { 
                      ?>
                        <td></td>
                      <?php } ?>
                        </td>
                        <td>{{$paper->DUEDATE}}</td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Assign paper to teacher -->

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
                        <input type="hidden" id='PAPER_IDs' name="PAPER_ID" value="">
                        <input type="hidden" id='CLASS_IDs' name="CLASS_ID" value="">
                        <input type="hidden" id='SECTION_IDs' name="SECTION_ID" value="">
                        <input type="hidden" id='SESSION_IDs' name="SESSION_ID" value="">
                        
                        <div class="form-group addteacher">
                           <label>Select Teacher*</label>
                     <select data-placeholder="Begin typing a name to filter..." multiple class="chosen-select" id="EMP_ID" name="EMP_ID[]">
                        @foreach($teachers as $teacher)
                           <option  value="{{ $teacher->EMP_ID}}">
                              {{ ucfirst($teacher->EMP_NAME) }}</option>
                           @endforeach
                        </select>
                        <small id="EMP_ID_error" class="form-text text-danger"></small>
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
 <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
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
   $(".chosen-select").chosen({max_selected_options: 5});


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
   $('body').on('change','#EXAM_ID',function(){
        var exam_id = $(this).val();
        var SESSION_ID = $('#SESSION_ID').val();
        var CLASS_ID = $('#class_id').val();
        var SECTION_ID = $('#sectionid').val();
        $.ajax({
        url: '{{url("getsubjectadmin")}}',
            type:'POST',
            data :{EXAM_ID:exam_id,SESSION_ID:SESSION_ID,CLASS_ID:CLASS_ID,SECTION_ID:SECTION_ID},
            // processData: false,
            // contentType: false,
            success: function(data){
                console.log(data);
         
             
            $('#SUBJECT_ID').empty();
            $('#SUBJECT_ID').append(`<option value="0" disabled selected>Select Subject*</option>`);
            data.forEach(element => {
                $('#SUBJECT_ID').append(`<option value="${element['SUBJECT_ID']}.${element['PAPER_ID']}">${element['SUBJECT_NAME']}</option>`);
                });
            },
        });
    });
   $('body').on('submit','#ap_tr',function(e){
   e.preventDefault();
   $('#SECTION_ID_error').text('');
   $('#CLASS_ID_error').text('');
   $('#SESSION_ID_error').text('');
   $('#EMP_ID_error').text('');
   $('#EXAM_ID_error').text('');
   $('#DUEDATE_error').text('');
   $('#SUBJECT_ID_error').text('');
   var fdata = new FormData(this);
    html="";
   $.ajax({
        url: '{{url("assign_paper_teacher")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
               //return false;
               if(data==true){
                toastr.success('Making Paper Assign To Teacher Successfully ', 'Notice');
                setTimeout(function(){location.reload();},1000);
                }
            else {
               toastr.warning('Paper Already Approved by Admin Please Check in Log', 'Notice');
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
        url: '{{url("assign_paper_teacher")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
            console.log(data);
            return false;
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
