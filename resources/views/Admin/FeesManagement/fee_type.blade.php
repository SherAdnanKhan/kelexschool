@extends('Admin.layout.master')
@section("page-css")
  <!-- DataTables -->
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
      <div class="card m-b-30 card-body">
            <h3 class="card-title font-16 mt-0">Define Fee Type</h3>
            <form action="{{ route('add-fee-type')}}" id="add-fee-type" name="add-fee-type" method="post" accept-charset="utf-8">
               <div class="row">
                  <div class="col-md-3">
                      <div class="form-group">
                           <label for="">{{Session::get('session')}}</label>
                              <small class="req"> *</small>
                              <select name="SESSION_ID" class="form-control formselect required" placeholder="Select Class"
                                 id="SESSION_ID">
                                 <option value="0" disabled selected>{{Session::get('session')}}*</option>
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
                        <label for="">{{Session::get('class')}}</label>
                           <small class="req"> *</small>
                           <select name="CLASS_ID" class="form-control formselect required" placeholder="Select Class"
                              id="class_id">
                              <option value="0" disabled selected>
                              {{Session::get('class')}} *</option>
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
                           <label for="">{{Session::get('section')}}</label>
                              <small class="req"> *</small>
                              <select name="SECTION_ID" class="form-control formselect required" placeholder="Select Section" id="sectionid" >
                           </select>
                           <small id="SECTION_ID_error" class="form-text text-danger"></small>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="">Fee Category</label>
                           <small class="req"> *</small>
                           <select name="FEE_CAT_ID" class="form-control category_id required" placeholder="Select Category"
                              id="FEE_CAT_ID">
                              <option value="0" disabled selected>
                                 Fee Category *</option>
                              @foreach($feecategory as $row)
                              <option  value="{{ $row->FEE_CAT_ID}}">
                                 {{ ucfirst($row->CATEGORY) }}</option>
                              @endforeach
                        </select>
                        <small id="FEE_CAT_ID_error" class="form-text text-danger"></small>
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group">
                        <label for="SHIFT"> Shift:</label><br>
                        <label class="radio-inline">

                        <input type="radio" id="morning" name="SHIFT" value="1" style=" margin: 10px;" checked > Morning
                        <input type="radio" id="evening" name="SHIFT" value="0" style=" margin: 10px;"> Evening
                        </label>
                        <small id="SHIFT_error" class="form-text text-danger"></small>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="col">
                        <div class="form-group" >
                           <label for="exampleInputclass1">TYPE</label><small class="req"> *</small>
                           <input autofocus="" id="FEE_TYPE" name="FEE_TYPE" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                           <small id="FEE_AMOUNT_error" class="form-text text-danger"></small>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                     <br><br>
                         <button type="submit" class="btn btn-primary btn-rounded btn-block waves-effect waves-light">Save</button>
                     </div>
                  </div>

               </div>
            @csrf
            </form>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-sm-11">
      <div class="card m-b-30 card-body">
         <h3 class="card-title font-16 mt-0">Fee Type List</h3>
         <div class="table-responsive">
         <table class="table table-striped table-bordered table-hover example dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
            <tr role="row">
               <th>Session</th>
               <th>Classes</th>
               <th>Sections</th>
               <th>Category</th>
               <th>Shift</th>
               <th>Type</th>
               <th>Action</th>
               </tr>
            </thead>
            <tbody id="displaydata">
            @if(isset($getfeecat))
            @foreach($getfeecat as $getfc)
               <tr id="row{{$getfc->FEE_ID}}">
                  <td> {{$getfc->SB_NAME}}</td>
                  <td> {{$getfc->Class_name}}</td>
                  <td> {{$getfc->Section_name}}</td>
                  <td> {{$getfc->CATEGORY}}</td>
                  <td> {{$getfc->SHIFT==1?'Morning':'Evening'}}</td>
                  <td> {{$getfc->FEE_TYPE}}</td>
                  <td><button value="{{$getfc->FEE_ID}}" class="btn btn-primary btn-xs editbtn" > edit </button> </td>
               </tr>
               @endforeach
            @endif
            </tbody>
         </table>
         </div>
      </div>
   </div>
</div>
 <!-- Edit feecat using modal -->
 <div class="modal fade bs-example-modal-lg" id="feeTypeEditModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title mt-0" id="myLargeModalLabel">Edit Fee Type Details</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                              </div>
                              <div class="modal-body">


               <div class="row">
                  <div class="col-md-3">
                  <form action="{{ route('update-fee-type')}}" id="update-fee-type" name="update-fee-type" method="post" accept-charset="utf-8">
                      <div class="form-group">
                           <label for="">session</label>
                              <small class="req"> *</small>
                              <input type="hidden" id="FEE_ID" name="FEE_ID" value="">
                              <select name="SESSION_ID" class="form-control formselect required" placeholder="Select Class"
                                 id="editSESSION_ID">
                                 <option value="0" disabled selected>Session*</option>
                                 @foreach($sessions as $session)
                                 <option  value="{{ $session->SB_ID }}">
                                    {{ ucfirst($session->SB_NAME) }}</option>
                                 @endforeach
                           </select>
                           <small id="SESSION_ID_err" class="form-text text-danger"></small>
                        </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="">Class</label>
                           <small class="req"> *</small>
                           <select name="CLASS_ID" class="form-control formselect required" placeholder="Select Class"
                              id="editCLASS_ID">
                              <option value="0" disabled selected>
                                 Class *</option>
                              @foreach($classes as $class)
                              <option  value="{{ $class->Class_id }}">
                                 {{ ucfirst($class->Class_name) }}</option>
                              @endforeach
                        </select>
                        <small id="CLASS_ID_err" class="form-text text-danger"></small>
                     </div>
                  </div>
                  <div class="col-md-3">
                        <div class="form-group">
                           <label for="">Section</label>
                              <small class="req"> *</small>
                              <select name="SECTION_ID" class="form-control formselect required" placeholder="Select Section" id="editSECTION_ID" >
                           </select>
                           <small id="SECTION_ID_err" class="form-text text-danger"></small>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="">Fee Category</label>
                           <small class="req"> *</small>
                           <select name="FEE_CAT_ID" class="form-control category_id required" placeholder="Select Category"
                              id="editFEE_CAT_ID">
                              <option value="0" disabled selected>
                                 Fee Category *</option>
                              @foreach($feecategory as $row)
                              <option  value="{{ $row->FEE_CAT_ID}}">
                                 {{ ucfirst($row->CATEGORY) }}</option>
                              @endforeach
                        </select>
                        <small id="FEE_CAT_ID_err" class="form-text text-danger"></small>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="SHIFT"> Shift:</label><br>
                        <label class="radio-inline">

                        <input type="radio" id="editmorning" name="SHIFT" value="1" style=" margin: 10px;" checked > Morning
                        <input type="radio" id="editevening" name="SHIFT" value="0" style=" margin: 10px;"> Evening
                        </label>
                        <small id="SHIFT_err" class="form-text text-danger"></small>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="col">
                        <div class="form-group" >
                           <label for="exampleInputclass1">Type</label><small class="req"> *</small>
                           <input autofocus="" id="editFEE_TYPE" name="FEE_TYPE" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                           <small id="FEE_AMOUNT_err" class="form-text text-danger"></small>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                     <br><br>
                         <button type="submit" class="btn btn-primary btn-rounded btn-block waves-effect waves-light">Save</button>
                     </div>
                  </div>

               </div>
            @csrf
            </form>
               </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
         </div><!-- /.modal -->
   </div>
  <!-- </div> </div> </div> -->
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
        } );
     </script>
<script>
   $(document).ready(function(){
    $('#class_id').on('change', function () {
                let id = $(this).val();
                $('#sectionid').empty();
                $('#sectionid').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'getsection/' + id,
                success: function (response) {
               //  var response = JSON.parse(response);
                //console.log(response);
                $('#sectionid').empty();
                $('#sectionid').append(`<option value="0" disabled selected>Select Section*</option>`);
                response.forEach(element => {
                    $('#sectionid').append(`<option value="${element['Section_id']}">${element['Section_name']}</option>`);
                    });
                }
            });
        });
        $('#editCLASS_ID').on('change', function () {
                let id = $(this).val();
                $('#editSECTION_ID').empty();
                $('#editSECTION_ID').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'getsections/' + id,
                success: function (response) {
                var response = JSON.parse(response);
                //console.log(response);
                $('#editSECTION_ID').empty();
                $('#editSECTION_ID').append(`<option value="0" disabled selected>Select Section*</option>`);
                response.forEach(element => {
                    $('#editSECTION_ID').append(`<option value="${element['Section_id']}">${element['Section_name']}</option>`);
                    });
                }
            });
        });
   });
</script>
<Script>
    $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$('body').on('submit','#add-fee-type',function(e){
      e.preventDefault();
      $('#CLASS_ID_error').text('');
      $('#SECTION_ID_error').text('');
      $('#SHIFT_error').text('');
      $('#SESSION_ID_error').text('');
      $('#FEE_CAT_ID_error').text('');

      var fdata = new FormData(this);

      $.ajax({
        url: '{{url("add-fee-type")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               if ($.trim(data) == '' ) {
                  toastr.success('Record Added..','Notice');
                  $("#add-fee-type").get(0).reset();
                  setTimeout(function(){location.reload();},1000);
                  }
                  else
                  {
                     toastr.error(data,'Notice');
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
    $(document).on('click', '.editbtn',function () {
        var FEE_ID = $(this).val();
        $.ajax({
            url: '{{url("edit-fee-type")}}',
            type: "GET",
            data: {
               FEE_ID:FEE_ID
            },
            dataType:"json",
            success: function(data)
         {
               console.log(data);
            $('#FEE_ID').val(data['FEE_ID'])
            $('#editCLASS_ID').val(data["CLASS_ID"]).change();
            $('#editSECTION_ID').val(data["SECTION_ID"]).change();
            (data.SHIFT=="1")?$('#editmorning').prop('checked', true):$('#editevening').prop('checked', true);
            $('#editSESSION_ID').val(data["SESSION_ID"]).change();
            $('#editFEE_CAT_ID').val(data["FEE_CAT_ID"]).change();
            $('#editFEE_AMOUNT').val(data["FEE_AMOUNT"])

         }

        });
       $('#feeTypeEditModal').modal('show');
   });

  $('body').on('submit','#update-fee-type',function(e){
      e.preventDefault();
      $('#CLASS_ID_err').text('');
      $('#SECTION_ID_err').text('');
      $('#CATEGORY_err').text('');
      $('#SHIFT_err').text('');
      $('#SESSION_ID_err').text('');
      $('#FEE_CAT_ID_err').text('');

      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("update-fee-type")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               console.log(data)
               if ($.trim(data) == '' ) {
                  toastr.success('Record Updated Sucessfully..','Notice');
                  $("#update-fee-type").get(0).reset();
                  $('#feeTypeEditModal').modal('hide');
                  setTimeout(function(){location.reload();},1000);

                  }
                  else
                  {
                     toastr.error(data,'Notice');
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


</script>


@endsection
