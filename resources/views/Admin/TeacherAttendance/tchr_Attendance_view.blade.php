@extends('Admin.layout.master')
@section("page-css")


@endsection
@section("content")
<div class="row">
   <div class="col-md-12">
      <div class="card m-b-30 card-body">
      <form action="" method="post">
          <div class="row">
           @csrf
            <!-- <div class="col-md-3">
              <div class="form-group">                          
              <label for="exampleInputclass1">Employee Name</label>
              <input autofocus="" id="EMP_NAME" name="EMP_NAME" placeholder="" type="text" class="form-control" value="" autocomplete="off">
              <small id="EMP_NAME_error" class="form-text text-danger"></small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                   <label>Date*</label>
                  <input type="date" class="form-control" name="date" id="date">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group" style="padding-top:10px;"><br>
              <button class="btn btn-primary search " type="submit" id="searchbtn"> Search <i class="fa fa-search"></i></button>
              </div>
              </form>
            </div> -->
            <div class="col-md-1"> </div>
            <div class="col-md-4">
            <form action="" id="searchallemp">
              <div class="form-group">
              <small id="alldate_err" class="form-text text-danger"></small>
                   <label>Date*</label>
                  <input type="date" class="form-control" name="alldate" id="alldate">
              </div>
            </div>
            <div class="col-md-">
              <div class="form-group" style="padding-top:13px;"><br>
              <button class="btn btn-primary search " id="searchallbtn" type="submit" > Search All <i class="fa fa-search"></i></button>
              </div>
              </form>
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

                <table class="table table-hover table-bordered">
                  <head>
                    <tr>
                      <th scope="col">#</th>
                      <!-- <th>ROLL-NO</th> -->
                      <th scope="col">Teacher Employee No</th>
                      <th scope="col">Teahcer NAME</th>
                      <th scope="col">FATHER NAME</th>
                      <th scope="col">ATTENDANCE</th>
                      <th scope="col">REMARKS</th>
                    </tr>
                  </thead>
                
                <tbody id="tchr-dev">
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
<script>
  $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
//////////////////////////  Get All Teachers list ///////////////

$('body').on('click','#searchallbtn',function(){
  $('alldate_err').text('');
  date = $('#alldate').val();
  $(this).addClass('disabled');
      $(this).attr('disabled',true);
      $.ajax({
            type : 'POST',
          data :{alldate:date, "_token": "{{ csrf_token() }}"},
            url : '/get-tchrall-for-attendance',
            success : function(res){
                $('#searchallbtn').removeClass('disabled');
                $('#searchallbtn').prop('disabled',false);
               
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
                       
                        console.log(data[key]['EMP_ID']);
                        html += "<tr>";
                        html += '<td>'+s+'</td>';
                        html += '<td>'+data[key]['EMP_NO']+'</td>';
                        html += '<td>'+data[key]['EMP_NAME']+'</td>';
                        html += '<td>'+data[key]['FATHER_NAME']+'</td>';
                        html += '<td>';
                        html += '<div class="custom-control custom-radio custom-control-inline">';
                        html +=   '<input type="hidden" name="EMP_ID[]" class="EMP_ID" value ="'+data[key]['EMP_ID']+'"/>';
                        html +=   '<input type="hidden" name="TCHR_ATTENDANCE_ID" class="attendance_ids" value ="'+data[key]['TCHR_ATTENDANCE_ID']+'"/>';
                        html += '     <input '+newAttendance+' '+present+' type="radio"  id="atten_status_'+data[key]['EMP_ID']+'_'+s+'1" name="atten_status_'+data[key]['EMP_ID']+'_'+s+'1" class="custom-control-input atten_status" value="P">';
                        html += '  <label class="custom-control-label" for="atten_status_'+data[key]['EMP_ID']+'_'+s+'1">Present</label>';
                        html += '</div>';
                        html += '<div class="custom-control custom-radio custom-control-inline">';
                        html += '  <input type="radio"  '+abscent+'   id="atten_status_'+data[key]['EMP_ID']+'_'+s+'2" name="atten_status_'+data[key]['EMP_ID']+'_'+s+'1" class="custom-control-input atten_status" value="A">';
                        html += ' <label class="custom-control-label" for="atten_status_'+data[key]['EMP_ID']+'_'+s+'2">Absent</label>';
                        html += ' </div>';
                        html += '<div class="custom-control custom-radio custom-control-inline">';
                        html += '  <input type="radio"   '+leave+'  id="atten_status_'+data[key]['EMP_ID']+'_'+s+'3" name="atten_status_'+data[key]['EMP_ID']+'_'+s+'1" class="custom-control-input atten_status" value="L">';
                        html += ' <label class="custom-control-label" for="atten_status_'+data[key]['EMP_ID']+'_'+s+'3">Leave</label>';
                        html += ' </div>';
                        html += '<div class="custom-control custom-radio custom-control-inline">';
                        html += '  <input type="radio"  '+sickleave+'   id="atten_status_'+data[key]['EMP_ID']+'_'+s+'4" name="atten_status_'+data[key]['EMP_ID']+'_'+s+'1" class="custom-control-input atten_status" value="SL">';
                        html += ' <label class="custom-control-label" for="atten_status_'+data[key]['EMP_ID']+'_'+s+'4">Sick Leave</label>';
                        html += ' </div>';
                        html += '</td>';
                        html += '<td><textarea class="form-control remarks" name="remarks[]"></textarea></td>';
                        html +="</tr>";
                        s = s+1;
                  });
                
                  $('#tchr-dev').html(html);
              $('.data-card').fadeIn('slow');
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
/////////////////////// Save Attendance /////////////////////////
$('body').on('click','.save-attendance',function(){
      $(this).removeClass('disabled');
      $(this).removeAttr('disabled',true);
      var teachrs_array = new Array();
        $('.EMP_ID').each(function () {
            teachrs_array.push($(this).val());
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
        teachersid : teachrs_array,
        atten_status : atten_status_array,
        remarks: remarks_array,
        date : date,
        update : update,
        attendance_ids : attendanceIDs_array,
        "_token": "{{ csrf_token() }}"
      }
      
     try{
        $.ajax({
            type : 'POST',
            url : '/save-teachers-attendance',
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