@extends('Admin.layout.master')
@section("page-css")
    <link rel="stylesheet" type="text/css" href="{{ url('assets/dist/css/dropify.min.css') }}">
@endsection
@section("content")
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="card m-b-20">
                  <div class="row">
                     <div class="col-2">
                          <a href="{{route('showstudent')}}" class="btn btn-info">Show Existing Students</a>

                     </div>
                  </div>
                <form id="updatestudent" action="{{route('updatestudent')}}"  method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        @csrf
                  <div class="card-body">
                      <div class="clearfix p-1">

                        <span class="float-left ">
                             <h4 class="register-heading">Student Admission</h4>
                                <p class="text-muted m-b-30 ">Please fill all the mandaortey fields .</p>
                        </span>
                        <span class="float-right ">
                             <label for="upload">Upload Student picture</label>
                                  <input type="file" name="IMAGE" id="IMAGE" size="20" class="dropify"  accept="image/*"/>
                                  <img src="{{ asset('upload')}}/{{Session::get('CAMPUS_ID')}}/{{$student['IMAGE']}}" alt="No image Found" style="width: 50px;height:50px;">
                                    <small id="IMAGE_error" class="form-text text-danger"></small> 
                               
                        </span>

                    </div>
                     <!-- student form start -->

                              <div class="row">
                                {{-- <div class="col-md-3">
                                    <label for="upload">Upload Student picture</label>
                                    <input type="file" name="IMAGE" id="IMAGE" size="20" class="dropify"  accept="image/*"/>
                                    <img src="{{ asset('upload')}}/{{$student['IMAGE']}}" alt="No image Found" style="width: 50px;height:50px;">
                                    <small id="IMAGE_error" class="form-text text-danger"></small>
                                 </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">{{Session::get('session')}}</label>
                                            <small class="req"> *</small>
                                            <select name="SESSION_ID" class="form-control formselect required" id="SESSION_ID" >
                                            <option value="">Select</option>
                                            @foreach($sessions as $session)
                                            <option value="{{$session->SB_ID}}" <?php if($std_session_data->SESSION_ID==$session->SB_ID) echo 'selected="selected"'; ?>>{{$session->SB_NAME}}</option>
                                                @endforeach
                                            </select>
                                            <small id="SESSION_ID_error" class="form-text text-danger"></small>
                                    </div>
                                </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="">Class</label>
                                       <small class="req"> *</small>
                                       <select name="CLASS_ID" class="form-control formselect required" placeholder="Select Class"
                                          id="class_id">
                                          <option value="0" disabled selected>Select
                                          {{Session::get('class')}}*</option>
                                          @foreach($classes as $class)
                                          <option  value="{{ $class->Class_id }}"  <?php if($std_session_data->CLASS_ID==$class->Class_id) echo 'selected="selected"'; ?>>
                                             {{ ucfirst($class->Class_name) }}</option>
                                          @endforeach
                                    </select>
                                    <small id="CLASS_ID_error" class="form-text text-danger"></small>
                                 </div>
                              </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <label for="">{{Session::get('section')}}</label>
                                            <small class="req"> *</small>
                                            <select name="SECTION_ID" class="form-control formselect required" placeholder="Select Section" id="sectionid" >
                                            <option  value="{{ $sections->Section_id }}" selected>
                                            {{ $sections->Section_name }}</option>
                                        </select>
                                        <small id="SECTION_ID_error" class="form-text text-danger"></small>
                                    </div>
                            </div>

                              </div>

                                <div class="row fee-div" style="display: block">
                                    <div class="form-group">
                                        <label>Fee Discount</label>
                                        <div class="dis-div">

                                            <ul class="list-inline">
                                                   @if(!empty($fee_discount))
                                                <li>
                                                    @foreach ($fee_discount as $item)
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3">{{$item->CATEGORY}}</span>
                                                            </div>
                                                            <input type="text" name="fee_discount[{{$item->FEE_CAT_ID}}]" class="form-control col-sm-2" id="basic-url" aria-describedby="basic-addon3" value="{{$item->DISCOUNT}}">
                                                        </div>
                                                    @endforeach

                                                </li>
                                                 @endif
                                            <ul>
                                        </div>
                                    </div>
                                </div>

                              <div class="row">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInputNAME1">Student Name </label>
                                       <small class="req"> *</small>
                                       <input id="STUDENT_ID" name="STUDENT_ID" placeholder="" type="hidden" value="{{$student['STUDENT_ID']}}" class="form-control">
                                       <input id="NAME" name="NAME" placeholder="" type="text" value="{{$student['NAME']}}"  class="form-control">
                                       <small id="NAME_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInpUTFNAME1">FATHER NAME</label>
                                       <small class="req"> *</small>
                                       <input id="FATHER_NAME" name="FATHER_NAME" placeholder="" type="text" value="{{$student['FATHER_NAME']}}"  class="form-control">
                                       <small id="FATHER_NAME_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputFNO1">Father Phone</label>
                                          <small class="req"> *</small>
                                          <input id="FATHER_CONTACT" name="FATHER_CONTACT" placeholder="" value="{{$student['FATHER_CONTACT']}}" type="text" class="form-control" >
                                          <small id="FATHER_CONTACT_error" class="form-text text-danger"></small>
                                       </div>
                                 </div>
                                 <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputFSNO1">Secondary Phone no</label>
                                          <small class="req"> *</small>
                                          <input id="SECONDARY_CONTACT" name="SECONDARY_CONTACT" placeholder="" value="{{$student['SECONDARY_CONTACT']}}" type="text" class="form-control" >
                                          <small id="SECONDARY_CONTACT_error" class="form-text text-danger"></small>
                                       </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInputGen"> Gender</label>
                                       <small class="req"> *</small>
                                       <select class="form-control" name="GENDER">
                                          <option value="" >Select</option>
                                          <option value="Male" <?php if($student['GENDER']=="Male") echo 'selected="selected"'; ?> >Male</option>
                                          <option value="Female" <?php if($student['GENDER']=="Female") echo 'selected="selected"'; ?>>Female</option>
                                       </select>
                                       <small id="GENDER_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInputdob1">Date of Birth</label>
                                       <small class="req"> *</small>
                                       <input id="DOB" name="DOB" placeholder=""  value="{{$student['DOB']}}"  type="date" class="form-control date">
                                       <small id="DOB_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>

                                 <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputFNO1">CNIC</label>
                                          <small class="req"> *</small>
                                          <input id="CNIC" name="CNIC" placeholder=""  value="{{$student['CNIC']}}" type="text" class="form-control" >
                                          <small id="CNIC_error" class="form-text text-danger"></small>
                                       </div>
                                 </div>
                                 <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputFNO1">RELIGION</label>
                                          <small class="req"> *</small>
                                          <input id="RELIGION" name="RELIGION" placeholder="" value="{{$student['RELIGION']}}" type="text" class="form-control" >
                                          <small id="RELIGION_error" class="form-text text-danger"></small>
                                       </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="Sins"> SHIFT:</label>
                                       <small class="req"> *</small>
                                       <label class="radio-inline">
                                       <small id="SHIFT_err" class="form-text text-danger"></small>
                                       <input  type="radio" id="Morning" name="SHIFT"  <?php echo($student['SHIFT']=='1'?'checked':''); ?> value="1" style=" margin: 10px;"  > Morning
                                       <input type="radio" id="Evening" name="SHIFT"  <?php echo ($student['SHIFT']=='2'?'checked':''); ?> value="2" style=" margin: 10px;"> Evening
                                       </label>
                                       <small id="SHIFT_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInputPAl1">Present address</label>
                                       <small class="req"> *</small>
                                       <input type="text" id="PRESENT_ADDRESS" name="PRESENT_ADDRESS" value="{{$student['PRESENT_ADDRESS']}}" class="form-control" >
                                       <small id="PRESENT_ADDRESSerror" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInputPAl1">PERMANENT ADDRESS</label>
                                       <small class="req"> *</small>
                                       <input type="text" id="PERMANENT_ADDRESS" name="PERMANENT_ADDRESS" value="{{$student['PERMANENT_ADDRESS']}}" class="form-control" >
                                       <small id="PERMANENT_ADDRESS_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInpUTFNAME1">GUARDIAN NAME</label>
                                       <small class="req"> *</small>
                                       <input id="GUARDIAN" name="GUARDIAN" placeholder="" type="text" value="{{$student['GUARDIAN']}}" class="form-control">
                                       <small id="GUARDIAN_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputFNO1">GUARDIAN CNIC</label>
                                          <small class="req"> *</small>
                                          <input id="GUARDIAN_CNIC" name="GUARDIAN_CNIC" placeholder="" type="text"  value="{{$student['GUARDIAN_CNIC']}}" class="form-control" >
                                          <small id="GUARDIAN_CNIC_error" class="form-text text-danger"></small>
                                       </div>
                                 </div>
                                 <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputFNO1">{{Session::get('campusname')}} Leaving Certificate</label>
                                          <small class="req"> *</small>
                                          <input id="SLC_NO" name="SLC_NO" placeholder="" type="number"  value="{{$student['SLC_NO']}}" class="form-control" >
                                          <small id="SLC_NO_error" class="form-text text-danger"></small>
                                       </div>
                                 </div>
                                 <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="exampleInputFNO1">Previous {{Session::get('campusname')}}</label>
                                          <small class="req"> *</small>
                                          <input id="PREV_BOARD_UNI" name="PREV_BOARD_UNI" placeholder="" value="{{$student['PREV_BOARD_UNI']}}" type="text" class="form-control" >
                                          <small id="PREV_BOARD_UNI_error" class="form-text text-danger"></small>
                                       </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="exampleInputdob1">Passing year</label>
                                       <small class="req"> *</small>
                                       <input id="PASSING_YEAR" name="PASSING_YEAR" placeholder="" value="{{$student['PASSING_YEAR']}}" type="date" class="form-control date">
                                       <small id="PASSING_YEAR_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">

                                  <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="exampleInputsection1">Previous {{Session::get('class')}} :  </label>
                                          <small class="req"> *</small>
                                          <select class="form-control formselect required" name="PREV_CLASS" id="PREV_CLASS" >
                                          @foreach($classes as $class)
                                          <option value="{{$class->Class_id}}"  <?php if($student['PREV_CLASS']==$class->Class_id) echo 'selected="selected"'; ?>>{{$class->Class_name}}</option>
                                                @endforeach
                                          </select>
                                          <small id="PREV_CLASS_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="exampleInputdob1">Previous {{Session::get('class')}} Marks</label>
                                       <small class="req"> *</small>
                                       <input id="PREV_CLASS_MARKS" name="PREV_CLASS_MARKS" placeholder="" value="{{$student['PREV_CLASS_MARKS']}}" type="text" class="form-control date">
                                       <small id="PREV_CLASS_MARKS_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-4">
                                    <div class="form-group">

                                    </div>

                                 </div>

                              </div>

                              <div class="box-footer text-center">

                                    <div class=" ">
                                       <button type="submit" class="btn btn-info btn-rounded align-items-right waves-effect waves-light">Update Student</button>
                                    </div>
                              </div>

                     <!-- student form end -->
                  </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section("customscript")
<script>
   $(document).ready(function(){
    $('.dropify').dropify();
    $('#class_id').on('change', function () {
                let id = $(this).val();
                $('#sectionid').empty();
                $('#sectionid').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: '/getsections/' + id,
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

    $('body').on('change','#sectionid',function(){
       session_id = $('#SESSION_ID').val();
       class_id = $('#class_id').val();
       section_id = $(this).val();
       var html = "";
       try {
        $.ajax({
            type:"GET",
            url: '/get-student-fee/'+session_id+'/'+class_id+'/'+section_id,
            success:function(res){
                if(res.length>0){
                    // for (let i = 0; i < res.length; i++) {
                    //     for (let j = 0; j < res[i].length; j++) {
                    //         console.log(res[i][j]['FEE_CATEGORY']);
                    //     }
                    // }
                    html += '<ul class="list-inline">';
                    $.each(res,function(key,value){
                        // $.each(value,function(k,val){
                            html +=  '<li>';
                            html +='<div class="input-group mb-3">';
                            html +='<div class="input-group-prepend">';
                            html += '<span class="input-group-text" id="basic-addon3">'+value['FEE_CATEGORY']+ ' = '+value['CATEGORY_AMOUNT']+'</span>';
                            html +='</div>';
                            html +='<input type="text" name="fee_discount['+value['FEE_CATEGORY_ID']+']" class="form-control col-sm-2" id="basic-url" aria-describedby="basic-addon3" placeholder="Discount">';
                            html +='</div>';
                            html +='</li>';
                        // });
                    });

                    html += '</ul>';
                    $('.dis-div').html(html);
                    $('.fee-div').css('display','block');
                }

            }
        });
       } catch (error) {
        alert(error);
       }
   });
</script>
</script>
<script>

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$('body').on('submit','#updatestudent',function(e){
      e.preventDefault();
      $('#NAME_error').text('');
      $('#FATHER_NAME_error').text('');
      $('#FATHER_CONTACT_error').text('');
      $('#SECONDARY_CONTACT_error').text('');
      $('#GENDER_error').text('');
      $('#DOB_error').text('');
      $('#CNIC_error').text('');
      $('#RELIGION_error').text('');
      $('#FATHER_CNIC_error').text('');
      $('#SHIFT_error').text('');
      $('#PRESENT_ADDRESS_error').text('');
      $('#PERMANENT_ADDRESS_error').text('');
      $('#GUARDIAN_error').text('');
      $('#GUARDIAN_CNIC_error').text('');
      $('#IMAGE_error').text('');
      $('#PREV_CLASS_error').text('');
      $('#SLC_NO_error').text('');
      $('#PREV_CLASS_MARKS_error').text('');
      $('#PREV_BOARD_UNI_error').text('');
      $('#PASSING_YEAR_error').text('');
      $('#SESSION_ID_error').text('');
      $('#CLASS_ID_error').text('');
      $('#SECTION_ID_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("updatestudent")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               console.log(data)
               //return false;
               toastr.success(data,'Notice');
               $("#updatestudent").get(0).reset();
               setTimeout(function() {
                location.reload();
               }, 1000);

              },
              error: function(error){
               console.log(error);
               toastr.error('Please Fill the Required Fields','Notice');
               var response = $.parseJSON(error.responseText);
                    $.each(response.errors, function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
    }



      });
    });
</script>
@endsection
