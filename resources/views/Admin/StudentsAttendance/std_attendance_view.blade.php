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
            <div class="col">
              <div class="form-group">
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
            <div class="col">
              <div class="form-group">
                <label for="">{{Session::get('class')}} *<span class="gcolor"></span> </label>
                  <select class="form-control formselect required" placeholder="Select Class"
                    id="class_id">
                    <option value="">Select
                    {{Session::get('class')}}*</option>
                    @foreach($classes as $class)
                    <option  value="{{ $class->Class_id }}">
                        {{ ucfirst($class->Class_name) }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                   <label>{{Session::get('section')}}*</label>
                  <select class="form-control formselect required" placeholder="Select Section" id="sectionid">
                    <option value="">Select
                  </select>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                   <label>Date*</label>
                  <input type="date" class="form-control" name="date" id="date">
              </div>
            </div>
            <div class="col">
              <div class="form-group"><br><br>
                <button class="btn btn-primary search " id="searchbtn"> Search <i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  <div class="row data-card" style="display:none">
   <div class="col-12">
   
      <div class="card m-b-30 card-body">
       <div class="w-auto p-3"><button class="btn btn-primary save-attendance">Save Attendance</button></div>
          <div class="row">
            <div class="col-12" id="displaydata">

                <table id='DataTables_Table_0' class="table table-hover table-bordered">
                  <head>
                    <tr>
                      <th scope="col">#</th>
                      <!-- <th>ROLL-NO</th> -->
                      <th scope="col">REG-NO</th>
                      <th scope="col">NAME</th>
                      <th scope="col">FATHER NAME</th>
                      <th scope="col">ATTENDANCE</th>
                      <th scope="col">REMARKS</th>
                    </tr>
                  </thead>
                
                <tbody id="std-dev">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('customscript')
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
  $(document).ready( function () {
      $('#DataTables_Table_0').DataTable();
        } );
//////////////////////////  Get Students list ///////////////
$('body').on('click','#class_id',function(){
     let id = $(this).val();
     $('#sectionid').html(`<option value="0" disabled selected>Processing...</option>`);
      $.ajax({
                type: 'GET',
                url: 'getsection/' + id,
                success: function (response) {
                // var response = JSON.parse(response);
                //console.log(response);   
                  var html = '<option value="">Select Section</option>';
                $.each(response,function(k,v){
                   html += '<option value="'+response[k]['Section_id']+'">'+response[k]['Section_name']+'</option>';
                    $('#sectionid').html(html);
                  });
                }
              });
        // });
});
////////////////////////// End Get Sections ///////////////

//////////////////////////  Get Students list ///////////////

$('body').on('click','.search',function(){

    session_id = $('#session_id').val();
    class_id = $('#class_id').val();
    section_id = $('#sectionid').val();
    date = $('#date').val();
   if(session_id == ""){
     toastr.error('Please Select session first','Error');
     return false;
   }
  if(class_id == ""){
     toastr.error('Please Select class first','Error');
      return false;
   }
  if(section_id == ""){
     toastr.error('Please Select section','Error');
      return false;
   }
  if(date == ""){
     toastr.error('Please Select Date','Error');
      return false;
   }
   try{
      $(this).addClass('disabled');
      $(this).attr('disabled',true);
      $.ajax({
            type : 'POST',
            url : '/get-std-for-attendance',
            data : {session_id:session_id,class_id:class_id,section_id, date:date,"_token": "{{ csrf_token() }}"},
            success : function(res){
                $('#searchbtn').removeClass('disabled');
                $('#searchbtn').prop('disabled',false);
               
                  var html = "";
                  var s = 1;

                  var update = 0;
                  var  data = res.record;
                  var newAttendance = "";
                     html +=   '<input type="hidden" name="update" class="update" value ="'+res.update+'"/>';
                     
                    $.each(data,function(key,val){
                      var present = ""; 
                      var abscent  =  ""; 
                      var leave = ""; 
                      var sickleave  = ""; 
                       if(res.update == 1){
                         var atten = data[key]['ATTEN_STATUS'];
                          switch (atten) {
                            case "P":
                              present = "checked";
                              break;
                          case "A":
                              abscent = "checked";
                              break;
                          case "L":
                              leave = "checked";
                              break;
                          case "SL":
                              sickleave = "checked";
                              break;
                          }
                       }else{
                         newAttendance = "checked";
                       }
                        console.log("Present ="+present);
                        console.log("abscent = "+abscent);
                        console.log('Leave = '+leave);
                        console.log('SickLeave = '+sickleave);
                        html += "<tr>";
                        html += '<td>'+s+'</td>';
                        html += '<td>'+data[key]['REG_NO']+'</td>';
                        html += '<td>'+data[key]['NAME']+'</td>';
                        html += '<td>'+data[key]['FATHER_NAME']+'</td>';
                        html += '<td>';
                        html += '<div class="custom-control custom-radio custom-control-inline">';
                        html +=   '<input type="hidden" name="student_id[]" class="student_id" value ="'+data[key]['STUDENT_ID']+'"/>';
                        html +=   '<input type="hidden" name="STD_ATTENDANCE_ID" class="attendance_ids" value ="'+data[key]['STD_ATTENDANCE_ID']+'"/>';
                        html += '     <input '+newAttendance+' '+present+' type="radio"  id="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'1" name="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'1" class="custom-control-input atten_status" value="P">';
                        html += '  <label class="custom-control-label" for="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'1">Present</label>';
                        html += '</div>';
                        html += '<div class="custom-control custom-radio custom-control-inline">';
                        html += '  <input type="radio"  '+abscent+'   id="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'2" name="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'1" class="custom-control-input atten_status" value="A">';
                        html += ' <label class="custom-control-label" for="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'2">Absent</label>';
                        html += ' </div>';
                        html += '<div class="custom-control custom-radio custom-control-inline">';
                        html += '  <input type="radio"   '+leave+'  id="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'3" name="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'1" class="custom-control-input atten_status" value="L">';
                        html += ' <label class="custom-control-label" for="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'3">Leave</label>';
                        html += ' </div>';
                        html += '<div class="custom-control custom-radio custom-control-inline">';
                        html += '  <input type="radio"  '+sickleave+'   id="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'4" name="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'1" class="custom-control-input atten_status" value="SL">';
                        html += ' <label class="custom-control-label" for="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'4">Sick Leave</label>';
                        html += ' </div>';
                        // html += '<div class="custom-control custom-radio custom-control-inline">';
                        // html += '  <input type="radio"  id="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'5" name="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'1" class="custom-control-input" value="HL">';
                        // html += ' <label class="custom-control-label" for="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'5">Abscent</label>';
                        // html += ' </div>';
                        // html += '</td>';
                        // html += '<div class="custom-control custom-radio custom-control-inline">';
                        // html += '  <input type="radio"  id="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'6" name="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'1" class="custom-control-input" value="H">';
                        // html += ' <label class="custom-control-label badge-secondary " for="atten_status_'+data[key]['STUDENT_ID']+'_'+s+'6">Holiday</label>';
                        // html += ' </div>';
                        html += '</td>';
                        html += '<td><textarea class="form-control remarks" name="remarks[]"></textarea></td>';
                        html +="</tr>";
                        s = s+1;
                  });
                  // console.log(html);
                  //  $('#displaydata').html(" ");
                  $('#std-dev').html(html);
              
              // $('#search').removeClass('disabled');
              // $('#search').removeAttr('disabled',true);
              //  $('.data-card').css('display','block');
              $('.data-card').fadeIn('slow');
            }
          });
   }catch(r){
      $('#searchbtn').removeClass('disabled');
      $('#searchbtn').prop('disabled',false);
     alert(r);
   }
   
});
////////////////////////// End Get Students list ///////////////

/////////////////////// Save Attendance /////////////////////////
$('body').on('click','.save-attendance',function(){
      $(this).removeClass('disabled');
      $(this).removeAttr('disabled',true);
      var stds_array = new Array();
        $('.student_id').each(function () {
            stds_array.push($(this).val());
        });
      var atten_status_array = new Array();
        $('.atten_status:checked').each(function () {
            atten_status_array.push($(this).val());
        });
      var remarks_array = new Array();
        $('.remarks').each(function () {
            remarks_array.push($(this).val());
        });
      var attendanceIDs_array = new Array();
        $('.attendance_ids').each(function () {
            attendanceIDs_array.push($(this).val());
        });
        var update = $('.update').val();
      attendance_data = {
        student_ids : stds_array,
        atten_status : atten_status_array,
        remarks: remarks_array,
        class_id : class_id,
        section_id : section_id,
        session_id : session_id,
        date : date,
        update : update,
        attendance_ids : attendanceIDs_array,
        "_token": "{{ csrf_token() }}"
      }
      
     try{
        $.ajax({
            type : 'POST',
            url : '/save-students-attendance',
            data : attendance_data,
            success : function(data){
              // $('#displaydata').html('<div class="alert alert-danger bg-danger text-white" role="alert"><strong>Success!</strong>'+data['status']+'</div>');
  
              $('.data-card').fadeOut('slow');
              toastr.success(data['status'],'Success');
            }
        });
     }catch(r){
             $(this).removeClass('disabled');
          $(this).prop('disabled',false);
        alert(r);
     }
});
/////////////////// ENd Save Attendance ////////////////////////
  
  </script>
@endsection