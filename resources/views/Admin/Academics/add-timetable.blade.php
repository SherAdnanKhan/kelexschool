@extends('Admin.layout.master')
@section("page-css")
<link href="https://unpkg.com/jquery-datetimepicker@2.5.20/build/jquery.datetimepicker.min.css" rel="stylesheet"/>
@endsection
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
                         <div class="col-md-3">
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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{Session::get('section')}}*</label>
                                    <small id="SECTION_ID_err" class="form-text text-danger"></small>
                                    <select class="form-control formselect required" placeholder="Select Section" name="SECTION_ID" id="sectionid">
                                    <option value="">Select {{Session::get('section')}}
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-3">
                                <div class="form-group">
                                    <label>Day*</label>
                                     <small id="day_err" class="form-text text-danger"></small>
                                    <select class="form-control formselect required" placeholder="Select Section" name="day" id="day">
                                    <option value="" disabled selected>Select Day </option>
                                    <option value="1" >Monday  </option>
                                    <option value="2" >Tuesday  </option>
                                    <option value="3" >Wenesday  </option>
                                    <option value="4" >Thrusday  </option>
                                    <option value="5" >Friday  </option>
                                    <option value="6" >Saturday  </option>
                                    <option value="7" >Sunday </select>

                           
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
               <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                     <style type="text/css">
                        .relative label.text-danger{position: absolute; left:5px; bottom:0;}
                     </style>
                     <div class="row clearfix">
                        <div class="col-md-12 column">
                        <small id="all_err" class="form-text text-danger"></small>
                           <a id="add_row" class="addrow addbtnright btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Add New</a>
                           <form method="POST" action="" id="form_monday" class="commentForm autoscroll" novalidate="novalidate">
                            @csrf
                          
                              <div class="">
                                 <table class="table table-bordered table-hover order-list tablewidthRS" id="tab_logic">
                                    <thead>
                                       <tr>
                                          <th>
                                             Subject                        
                                          </th>
                                          <th>
                                             Teacher                        
                                          </th>
                                          <th>
                                             Time From                        
                                          </th>
                                          <th>
                                             Time To                        
                                          </th>
                                          <th class="text-right">
                                             Action                        
                                          </th>
                                       </tr>
                                    </thead>
                                   
                                    <tbody id="tabledata">
                                 
                                
                                    </tbody>
                                 </table>
                              </div>
                              <input class="btn btn-primary btn-sm pull-right" type="submit">
                           </form>
                        </div>
                     </div>
                   
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://unpkg.com/jquery-datetimepicker"></script>

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
   $('#day_err').text('');
   e.preventDefault();
   $('#inputfields').empty();  
   var fdata = new FormData(this);
   html="";
   htmlrow="";
   row_incr=0;
   $.ajax({
        url: '{{url("Searchtimetable")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
               subject=data.subject;
               teacher=data.teacher;
               SECTION_ID=data.SECTION_ID;
               CLASS_ID=data.CLASS_ID;
               GROUP_ID=data.GROUP_ID;
               DAY=data.DAY;
               timetable=data.timetable;
               console.log(data.timetable);
               html+=' <input type="hidden" name="CLASS_ID" value="'+CLASS_ID+'">';
               html+=' <input type="hidden" name="DAY" value="'+DAY+'">';
               html+=' <input type="hidden" name="SECTION_ID" value="'+SECTION_ID+'">';
               html+=' <input type="hidden" name="GROUP_ID" value="'+GROUP_ID+'">'; 

               htmlrow+='<td><small id="SUBJECT_ID_err" class="form-text text-danger"></small>\
                        <select class="form-control subject select2-hidden-accessible" id="subject_id_1" name="SUBJECT_ID[]" tabindex="-1" aria-hidden="true">';
              htmlrow+='<option value=""  selected > Please Select Subject </option>';
                      for(var i=0;i<subject.length;i++){
                  htmlrow+='<option value="'+subject[i]["SUBJECT_ID"]+'" >';
                  htmlrow+=                   subject[i]["SUBJECT_NAME"];                                                   
                  htmlrow+='                              </option>';
                      }
               htmlrow+='                        </select>';          
               htmlrow+='                          </span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>';
               htmlrow+='                     </td>';
               htmlrow+='                     <td>';
               htmlrow+='                        <small id="EMP_ID_err" class="form-text text-danger"></small>';    
               htmlrow+='                        <select class="form-control staff select2-hidden-accessible" id="staff_id_1" name="EMP_ID[]" tabindex="-1" aria-hidden="true">';
               htmlrow+='<option value=""  selected > Please Select Employee </option>';
                                             for(var i=0;i<teacher.length;i++){
                  htmlrow+='                              <option value="'+teacher[i]["EMP_ID"]+'">';
                  htmlrow+=                   teacher[i]["EMP_NAME"];                                                   
                  htmlrow+='                              </option>';
                                                      }
               htmlrow+='                              </select>';
               htmlrow+='                       </td>';
               htmlrow+='                     <td>';
               htmlrow+='                        <div class="input-group">';
               htmlrow+='       <small id="TIMEFROM_err" class="form-text text-danger"></small>';
               htmlrow+='                           <input type="text" name="TIMEFROM[]" autocomplete="off" class="form-control timetimetable time_from time" id="time_from_1"  onclick="myfun();" value="">';
               htmlrow+='                           <div class="input-group-addon">';
               htmlrow+='                           </div>';
               htmlrow+='                        </div>';
               htmlrow+='                     </td>';
               htmlrow+='                     <td>';
               htmlrow+='                        <div class="input-group">';
               htmlrow+='       <small id="TIMEFROM_err" class="form-text text-danger"></small>';
               htmlrow+='                           <input type="text" name="TIMETO[]" autocomplete="off" class="form-control timetimetable time_to time" id="time_to_1"  onclick="myfun();" value="">';
               htmlrow+='                           <div class="input-group-addon">';
               htmlrow+='                           </div>';
               htmlrow+='                        </div>';
               htmlrow+='                     </td>';
               if ($.trim(timetable) == '' ) {
               html +='<p id="p1" style="text-align:center;color:red;"> NO Result Match, Add New </p>';
               }
                else
                {

                for(var time=0;time<timetable.length;time++){
               
               html+='<tr id=new'+row_incr+'><td>'; 
               html+=' <input type="hidden" name="TIMETABLE_ID[]" value="'+timetable[time]['TIMETABLE_ID']+'">';
               html+=' <small id="SUBJECT_ID_err" class="form-text text-danger"></small>';
               html+='<select class="form-control subject select2-hidden-accessible" id="subject_id_1" name="SUBJECT_ID[]" tabindex="-1" aria-hidden="true">';
               html+='<option value="" disabled> Please Select Subject </option>';
                      for(var i=0;i<subject.length;i++){
                  var res=(timetable[time]['SUBJECT_ID']==subject[i]["SUBJECT_ID"])?'selected':''
                  html+='<option value="'+subject[i]["SUBJECT_ID"]+'"'+res+ '>';
                  html+=                   subject[i]["SUBJECT_NAME"];                                                   
                  html+='                              </option>';
                      }
               html+='                        </select>';
               html+='                          </span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>';
               html+='                     </td>';
               html+='                     <td>';
               html+='                        <small id="EMP_ID_err" class="form-text text-danger"></small>';    
               html+='                        <select class="form-control staff select2-hidden-accessible" id="staff_id_1" name="EMP_ID[]" tabindex="-1" aria-hidden="true">';
               html+='                            <option value="">Select</option>';
                                             for(var i=0;i<teacher.length;i++){
                                       var res_e=(timetable[time]['EMP_ID']==teacher[i]["EMP_ID"])?'selected':''
                  html+='                              <option value="'+teacher[i]["EMP_ID"]+'" '+res_e+'>';
                  html+=                   teacher[i]["EMP_NAME"];                                                   
                  html+='                              </option>';
                                                      }
               html+='                              </select>';
               html+='                       </td>';
               html+='                     <td>';
               html+='                        <div class="input-group">';
               html+='       <small id="TIMEFROM_err" class="form-text text-danger"></small>';
               html+='                           <input type="text" name="TIMEFROM[]" class="form-control timetimetable time_from time"  onclick="myfun();" value="'+timetable[time]['TIMEFROM']+'">';
               html+='                           <div class="input-group-addon">';
               html+='                           </div>';
               html+='                        </div>';
               html+='                     </td>';
               html+='                     <td>';
               html+='                        <div class="input-group">';
               html+='       <small id="TIMETO_err" class="form-text text-danger"></small>';
               html+='                           <input type="text" name="TIMETO[]" class="form-control timetimetable time_to time"  onclick="myfun();" value="'+timetable[time]['TIMETO']+'">';
               html+='                           <div class="input-group-addon">';
               html+='                           </div>';
               html+='                        </div>';
               html+='                     </td>';
               html+='                     <td class="text-right"><a href id="deletebtn" class=" btn btn-danger" data-id="'+timetable[time]['TIMETABLE_ID']+'"> <i class="fa fa-trash"></i></a></td></tr>';
            }
                }  
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

   function myfun() {
   $(".timetimetable").datetimepicker({
      datepicker: false,
      step: 30,
      minTime:'08:00',
      maxTime:'18:00',
      format: 'H:i'
      });
   }
      
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
             console.log(data);
               if(data==true){
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
                $("#all_err").text("Please Fill All Required Fields Correctly! Or Time From and End Must be Unique");
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