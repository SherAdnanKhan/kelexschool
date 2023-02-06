@extends('Admin.layout.master')
@section("page-css")


@endsection
@section("content")
<div class="row">
   <div class="col-md-12">
    
      <div class="card m-b-30 card-body">
      <h4>Search For Non Present Students</h4>
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
           
           
          </div>
          <div class="row">
            <div class="col">
                <div class="form-group">
                   <label>From Date *</label>
                   <input type="date" class="form-control fromdate" name="fromdate" id="fromdate">
                </div>
              </div>
             <div class="col">
               <div class="form-group">
                   <label>To Date *</label>
                  <input type="date" class="form-control todate" name="todate" id="todate">
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
       <!-- <div class="w-auto p-3"><button class="btn btn-primary save-attendance">Save Attendance</button></div> -->
          <div class="row">
            <div class="col-12" id="displaydata">

                <table class="table table-hover table-bordered">
                  <head>
                    <tr>
                      <th scope="col">#</th>
                      <!-- <th>ROLL-NO</th> -->
                      <th scope="col">REG-NO</th>
                      <th scope="col">NAME</th>
                      <th scope="col">FATHER NAME</th>
                      <th scope="col">CLASS</th>
                      <th scope="col">SECTION</th>
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
<script>
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
    fromdate = $('#fromdate').val();
    todate = $('#todate').val();
   if(session_id == ""){
     toastr.error('Please Select session first','Error');
     return false;
   }
 
  if(fromdate == ""){
     toastr.error('Please Select From-Date','Error');
      return false;
   }
  if(todate == ""){
     toastr.error('Please Select To-Date','Error');
      return false;
   }
   try{
      $(this).addClass('disabled');
      $(this).attr('disabled',true);
      $.ajax({
            type : 'POST',
            url : '/get-abscent-list',
            data : {session_id:session_id,class_id:class_id,section_id, fromdate:fromdate,todate:todate,"_token": "{{ csrf_token() }}"},
            success : function(res){
                $('#searchbtn').removeClass('disabled');
                $('#searchbtn').prop('disabled',false);
                var data = res;
                  var html = "";
                  var s = 1;
                     
                    $.each(data,function(key,val){

                        html += "<tr>";
                        html += '<td>'+s+'</td>';
                        html += '<td>'+data[key]['REG_NO']+'</td>';
                        html += '<td>'+data[key]['NAME']+'</td>';
                        html += '<td>'+data[key]['FATHER_NAME']+'</td>';
                        html += '<td>'+data[key]['Class_name']+'</td>';
                        html += '<td>'+data[key]['Section_name']+'</td>';
                        // html += '<td>'+data[key]['Class_name']+'</td>';
                        // html += '<td>';
                        // html += '</td>';
    
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


  
  </script>
@endsection