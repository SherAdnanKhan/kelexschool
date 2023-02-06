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
                    <form action="" id="need_to_upload" method="post">
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
            <div class="col-md-2">
              <div class="form-group">
                   <label>{{Session::get('section')}}*</label>
                  <select class="form-control formselect required" placeholder="Select Section" name="SECTION_ID" id="sectionid">
                    <option value="0" disabled selected>Select {{Session::get('section')}}
                  </select>
                  <small id="SECTION_ID_error" class="form-text text-danger"></small>
              </div>
            </div>
                <div class="col-md-2">
              <div class="form-group">
                   <label>Subject*</label>
                  <select class="form-control formselect required" placeholder="Select Subject" name="SUBJECT_ID" id="SUBJECT_ID">
                    <option value="0" disabled selected>Select
                    @foreach($subjects as $subject)
                    <option  value="{{ $subject->SUBJECT_ID }}">
                        {{ ucfirst($subject->SUBJECT_NAME) }}</option>
                    @endforeach
                  </select>
                  <small id="SUBJECT_ID_error" class="form-text text-danger"></small>
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
            <div class="col-md-12" id="Tabledata">
         
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Assign paper to teacher -->


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
   $('body').on('submit','#need_to_upload',function(e){
   e.preventDefault();
   $('#SECTION_ID_error').text('');
   $('#CLASS_ID_error').text('');
   $('#SESSION_ID_error').text('');
   $('#SUBJECT_ID_error').text('');
   var fdata = new FormData(this);
    html="";
   $.ajax({
        url: '{{url("teacher/need_to_upload")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
                if ($.trim(data) == '' ) {
                    html +='<p style="text-align:center;color:red;"> NO Result Match </p>';
                  }
                  else
                  {

                    html += '<form action="" id="check_upload" method="post">';
                    html += ' <div class="table-responsive">';
                    html += '    <table id="DataTables_Table_0" class="table table-striped table-bordered table-hover " style="border-collapse: collapse; border-spacing: 0; width: 100%;">\
                <thead>\
                      <tr>\
                        <th scope="col">Session</th>\
                        <th scope="col">Class</th>\
                        <th scope="col">Section</th>\
                        <th scope="col">Subject</th>\
                        <th scope="col">Upload Status</th>\
                        <th scope="col">File</th>\
                        <th scope="col">Due Date</th>\
                      </tr>\
                    </thead>\
                      <tbody>';
                      for (i = 0; i < data.length; i++)  
                    {
                     var uploadstatus = data[i].UPLOADSTATUS==1?'Pending':'Uploaded';
                      var UPLOADFILE =data[i].UPLOADFILE==null ? '' : data[i].UPLOADFILE;
                    
                    html+=' <tr id="row'+data[i].PAPER_MARKING_ID+'">\
                      <td><input type="hidden" name="PAPER_MARKING_ID[]" value="'+data[i].PAPER_MARKING_ID+'">'  +data[i].SB_NAME+'</td>\
                      <td>'+data[i].Class_name+'</td>\
                      <td>'+data[i].Section_name+'</td>\
                      <td>'+data[i].SUBJECT_NAME+'</td>\
                      <td>'+uploadstatus+'</td>';
                     if(data[i].UPLOADSTATUS==1 || data[i].UPLOADSTATUS==2){
                    html+='<td> <input type="file" name="UPLOADFILE" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" value="'+UPLOADFILE+'">   </td>';
                        }
                      html+='<td>'+data[i].DUEDATE+'</td>\
                      </tr>';
                     }
                     html+='   </tbody>\
                    </table>';
                
                   html += '<input type="submit" class="btn pull-right btn-primary submitbtn">';
                    html += '</form>';
                   html += '</div>';

                  }
                  $("#Tabledata").empty();
                $('#Tabledata').html(html);
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

$('body').on('submit','#check_upload',function(e){
e.preventDefault();
$('#UPLOADFILE_error').text('');
var fdata = new FormData(this);
   $.ajax({
        url: '{{url("teacher/upload_paper")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
            console.log(data);
            if(data==true){
                toastr.success('Paper uploaded Successfully', 'Notice');
                setTimeout(function(){location.reload();},1000);
                }
            else {
               toastr.warning('Paper Already Successfully', 'Notice');
            }
            },
            error: function(error){
               console.log(error);
            toastr.error('Image Must Be Upload in format doc,pdf,docx,zip', 'Notice');
            }

   });
   });
</script>

@endsection
