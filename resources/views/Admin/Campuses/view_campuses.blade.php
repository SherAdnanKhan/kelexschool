@extends('Admin.layout.master')
@section("page-css")
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
<link href="{{asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section("content")

                      <div class="page-content-wrapper">
                        <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
    
                                            <h4 class="mt-0 header-title">Campus Details</h4>
                                           
                                            <div class="table-responsive">
                                            <table id="DataTables_Table_0" class="table table-striped table-bordered table-hover " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                  <th scope="col">Campus ID</th>
                                                  <th scope="col">School Name</th>
                                                  <th scope="col">School Adresss</th>
                                                  <th scope="col">School Contact</th>
                                                  <th scope="col">School Email</th>
                                                  <th scope="col">City</th>
                                                  <th scope="col">Agreement</th>
                                                  <th scope="col">Agreement Date</th>
                                                  <th scope="col">School Logo</th>

                                                  <th scope="col">Edit</th>
                                                  <th scope="col">Delete</th>
                                                </tr>
                                                </thead>
    
    
                                                <tbody id="displaydata">
                        
                                                  @foreach ($campuses as $campus)
                                                  <tr id="row{{$campus->CAMPUS_ID}}">
                                                    <td>{{$campus->CAMPUS_ID}}</td>
                                                    <td>{{$campus->SCHOOL_NAME}}</td>
                                                    <td>{{$campus->SCHOOL_ADDRESS}}</td>
                                                    <td>{{$campus->PHONE_NO}}</td>
                                                    <td>{{$campus->SCHOOL_EMAIL}}</td>
                                                    <td>{{$campus->CITY_ID}}</td>
                                                    <td>{{$campus->AGREEMENT==1?'Yes':'No'}}</td>
                                                    <td>{{$campus->AGREEMENT_DATE}}</td>
                                                    <td><img src="{{ asset('upload') }}/{{$campus->LOGO_IMAGE}}" alt="" style="width: 50px;height:50px;"></td>
                                                    <td>
                                                        <button class="btn btn-success editbtn" value="{{$campus->CAMPUS_ID}}">Edit</button>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger deletebtn" value="{{$campus->CAMPUS_ID}}">Delete</button>
                                                    </td>
                                                  </tr>
                                                  @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                            <a href="{{route('campus')}}" class="btn btn-primary">Add New Campus</a>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                      </div>
    
<div class="modal fade bs-example-modal-lg" id="campusEditModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Edit Campus Details</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">

                              <form method="post" action="{{ route('updatecampus')}}" id="editcampus" enctype="multipart/form-data">
                                 <div class="row register-form">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            
                                            <input type="hidden" id="cid" class="form-control" name="campusid" placeholder="Enter Campus id *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="sname" class="form-control" name="schoolname" placeholder="Enter School name *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="saddress" class="form-control" name="schooladdress" placeholder="Enter School Address *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="pno" class="form-control"  name="phoneno" placeholder="Enter Phone No *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="mno" class="form-control"  name="mobileno" placeholder="Enter Mobile No *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="sreg" class="form-control"  name="schoolregistration" placeholder="Enter School Registration *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="smail" class="form-control"  name="schoolemail" placeholder="Enter School Email *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="sweb" class="form-control"  name="schoolwebsite" placeholder="Enter School Website *" value="" />
                                        </div>
                                        <div class="form-group">
                                        <label for="myfile">Upload School Logo:</label>
                                        <input type="file" id="myfile" name="schoollogo">
                                        <img id="myfile-img"  alt="" style="width: 50px;height:50px;">
                                        <br><br>
                                        </div>
                                        <div class="form-group">
                                        <select name="city" id="city">
                                        @foreach($cities as $city)
                                        <option value="{{$city->city_id}}">{{$city->city_name}}</option>
                                        @endforeach
                                        </select>
                                        </div>
                                        <div class="form-group">
                                       
                                         <p>Please Select Instuition Type:</p>
                                         <label class="radio-inline">
                                          <input type="radio" id="sins" name="instuition" value="school" > School
                                          <input type="radio" id="lins" name="instuition" value="L_instuition"> Learning Instution
                                         </label>
                                    </div>
                                    </div>
                                  <div class="col-md-6">
                                        <div class="form-group">
                                        <p>Please Select If you accept Agreement:</p>
                                            <label class="radio-inline">
                                              <input type="radio" id="agree1" name="Aggreement" value="1"> Yes
                                              <input type="radio" id="agree0" name="Aggreement" value="0"> No
                                            </label>
                                        </div>
                                        <div class="form-group">
                                        <label for=agreement> Enter Agreement date</label>
                                       <input type="date" id="adate" class="form-control" name="agreementdate" value="" />
                                        </div>
                                        <div class="form-group">
                                        <p>Please Enter Status:</p>
                                         <label class="radio-inline">
                                          <input type="radio" id="status1" name="status" value="1"> Active
                                          <input type="radio" id="status0" name="status" value="0"> Not Active
                                         </label>
                                        </div>
                                         <div class="form-group">
                                        <p>Please Select Sms Allowed or not Allowed:</p>
                                         <label class="radio-inline">
                                          <input type="radio" id="smsstatus1" name="smsstatus" value="1"> Allowed
                                          <input type="radio" id="smsstatus0" name="smsstatus" value="0"> Not Allowed
                                         </label>
                                         </div>
                                         @csrf
                                         <div class="form-group" style="border-style: solid;border-color: coral; padding:40px">
                                        <label> Enter Billing Details</label>
                                        <br>
                                        <input type="number" id="bchar" class="form-control" name="billingcharges" placeholder="Enter charges *" value="" />
                                        <input type="number" id="dis" class="form-control" name="discount" placeholder="Enter Discount *" value="" />
                                        <div class="form-group">
                                        <p> Please Select Billing Date</p>
                                            <input type="date" id="bdate" class="form-control" name="billingdate" placeholder="Enter Agreement date *" value="" />
                                        </div>
                                        </div>
                                   
                                    </div>
                                </div>
                                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="editcampus">Save changes</button>
                     </div>
                           @csrf
                     </form>

                  
                   
               </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
         </div><!-- /.modal -->
   </div>

@endsection

@section("customscript")
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

    $(document).ready(function(){
        $("#city").select2();
    });
    $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
    $('body').on('click', '.editbtn',function () {
        var campusid = $(this).val();
        $.ajax({
            url: '/editcampus',
            type: "GET",
            data: {
               campusid:campusid
            }, 
            dataType:"json",
            success: function(data){
                //console.log(data);
          for(i=0;i<data.length;i++){
            $('#cid').val(data[i].CAMPUS_ID);
            $('#sname').val(data[i].SCHOOL_NAME);
            $('#saddress').val(data[i].SCHOOL_ADDRESS);
            $('#pno').val(data[i].PHONE_NO);
            $('#mno').val(data[i].MOBILE_NO);
            $('#myfile-img').attr('src','{{ url("upload") }}/'+data[i].LOGO_IMAGE);
            (data[i].TYPE=='school')?$('#sins').prop('checked', true):$('#lins').prop('checked', true);
            (data[i].AGREEMENT==1)?$('#agree1').prop('checked', true):$('#agree0').prop('checked', true);
            (data[i].STATUS==1)?$('#status1').prop('checked', true):$('#status0').prop('checked', true);
            (data[i].SMS_ALLOWED==1)?$('#smsstatus1').prop('checked', true):$('#smsstatus0').prop('checked', true);
            $('#sreg').val(data[i].SCHOOL_REG);
            $('#smail').val(data[i].SCHOOL_EMAIL);
            $('#sweb').val(data[i].SCHOOL_WEBSITE);
            $('#cityid').val(data[i].CITY_ID);
            $('#adate').val(data[i].AGREEMENT_DATE);
            $('#bchar').val(data[i].BILLING_CHARGE);
            $('#dis').val(data[i].BILLING_DISCOUNT);
            $('#bdate').val(data[i].DUE_DATE);
          }
            }
        });
        $('#campusEditModal').modal('show');
  });
  $('body').on('submit','#editcampus',function(e){
      e.preventDefault();
      var fdata = new FormData(this);
      var html = "";
      // console.log(data);
      $.ajax({
        url: '/updatecampus',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){ 
              if(data){
                $("#editcampus").get(0).reset();
                $('#campusEditModal').modal('hide');
                toastr.success('Action Performed Successfully','Notice')
                setTimeout(function(){location.reload();},1000);
              }
              else
              {
                toastr.warning('Email Already Exist In Other Campuses','Notice')
              }
        
            
            }
              
              ,
              error: function(error){
                console.log(error);
              }
      
      });
    });

    $('body').on('click', '.deletebtn',function () {
        var dcampusid = $(this).val();
        $.ajax({
            url: '{{url("deletecampus")}}',
            type: "GET",
            data: {
               dcampusid:dcampusid
            }, 
            dataType:"json",
            success: function(data){
              alert("delete successfully");
              $('#row' + data).remove();
            }
        });
      });

    </script>
               
@endsection