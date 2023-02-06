@extends('Admin.layout.master')

@section('content')
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="card m-b-20">
                  <div class="row">
               <div class="col-md-12">
            <form action="" id="searching" method="post" accept-charset="utf-8">
            @csrf

               <div class="box-body">
                  <input type="hidden" name="ci_csrf_token" value="">                            
                  <div class="row">
                         <div class="col-md-4">
                                <div class="form-group">
                                    <label >Subject Group *<span class="gcolor" ></span> </label>
                                  <small id="GROUP_ID_err" class="form-text text-danger"></small>
                                    <select class="form-control formselect required" placeholder="Select Subject Group" name="GROUP_ID"
                                    id="group_id">
                                    <option value="">Select Subject Group</option>
                                        @foreach($subjectgroups as $row)
                                        <option  value="{{ $row->GROUP_ID  }}">{{ ucfirst($row->GROUP_NAME) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form-group">
                                <label for="">{{Session::get('class')}} *<span class="gcolor"></span> </label>
                                <small id="CLASS_ID_err" class="form-text text-danger"></small>
                                    <select class="form-control formselect required" placeholder="Select Class" name="CLASS_ID"
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
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{Session::get('section')}}*</label>
                                    <small id="SECTION_ID_err" class="form-text text-danger"></small>
                                    <select class="form-control formselect required" placeholder="Select Section" name="SECTION_ID" id="sectionid">
                                    <option value="">Select {{Session::get('section')}}
                                    </select>
                                </div>
                        </div>
                       
                  </div>
               </div>
               
               <div class="box-footer">
                  <button type="submit" class="btn btn-primary pull-right btn-sm">Search</button>
               </div>
            </form>
            </div>
   </div> 

                        <div id="myDIV" style="display:none">
                              <div class="box-body">
                           <div class="table-responsive">
                           <table class="table" id="customers">
                              <thead id="theads">
                              </thead>
                                    <tbody id="tabledata">
                                 
                                
                                    </tbody>
                                 </table>
                              </div>
                        </div>
                     </div>
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
   $("#myDIV").hide();
   $('#GROUP_ID_err').text('');
   $('#CLASS_ID_err').text('');
   $('#SECTION_ID_err').text('');
   e.preventDefault();
   $('#inputfields').empty();  
   var fdata = new FormData(this);
   html="";
   thead="";
   row_incr=0;
   $.ajax({
        url: '{{url("showtimetable")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
              // return false;
               WEEK_DAYS= data.WEEK_DAYS;
               console.log(WEEK_DAYS.length);
               calendarData=data.calendarData;
               //console.log(data);
               if ($.trim(data) == '' ) {
               html +='<p id="p1" style="text-align:center;color:red;"> NO Result Match, Add New </p>';
               }  
                else
               {
               thead+=' <th width="125">Time</th>';
               $.each(WEEK_DAYS, function (index, days) {
                  thead+=' <th> '+days+' </th>';
                 }); 
      
              
               $.each(calendarData, function (time, days) {
                  html+='    <tr>';
                  html+=' <td> '+time+' </td>';
               $.each(days, function (value1, value) {
                
                if (typeof value=='object' )
                {
                  html+='  <td rowspan="'+value["rowspan"]+'" class="align-middle text-center" style="background-color:#f0f0f0;width:100px;height:20px">  Subject: '+value['subject_name']+'<br>';
                  html+='  Room : '+value['class_name']+'<br>';
                  html+='  Teacher: '+value['teacher_name']+' </td>';
               
                }
                 else if (value === 1)
                    {
                  html+='<td></td>';
                     }           
                     });
                  html+=' </tr> ';
               });
               }
               console.log(thead);
            $('#theads').html(thead); 
            $('#tabledata').html(html);  
            
            $("#myDIV").show();         
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
$('body').on('click', '#add_row',function () {
   $("#p1").empty();     
  row_incr+=1;
  $('#tab_logic tbody:last-child').append('<tr id="row'+row_incr+'">'+htmlrow+' <td class="text-right"><button class="deleteelement btn btn-danger" value="'+row_incr+'">  <i class="fa fa-trash"></i></button></td></tr>');
 
      });
      
 $('body').on('click', '.deleteelement',function () {
    let deleteval= $(this).val();
    $('#row' + deleteval).remove();
  });


$('body').on('submit','#form_monday',function(e){
   e.preventDefault();
   $(".deletebtn").prop('disabled', false); 
  //s return false;
   $('#all_err').text('');
   var fdata = new FormData(this);
   $.ajax({
        url: '{{url("Savetimetable")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
             // return false;
               if(data){
                 // return false;
                
                toastr.success('Timetable for Monday added', 'Notice');
               setTimeout(function(){location.reload();},1000);
                }
                else{
                    toastr.error("Already other Subject Exist on Paticular date", 'Notice');
                }
            },
            error: function(error){
                console.log(error);
                $("#all_err").text("Please Fill All Required Fields Correctly!");
            }
   });
});
$('body').on('click', '#deletebtn',function (e) {
      e.preventDefault();
      let T_ID = $(this).attr('data-id');
        $.ajax({
            url: '{{url("deletetimetable")}}',
            type: "GET",
            data: {
               T_ID:T_ID
            }, 
            dataType:"json",
            success: function(data){
            if(data){
            toastr.success('Successfully Deleted', 'Notice');
            setTimeout(function(){location.reload();},1000);
            }
            else
            {
            toastr.warning('Already Deleted Please Refresh', 'Notice');
            setTimeout(function(){location.reload();},1000);
            }
              
            }
        });
      });

      
</script>

@endsection