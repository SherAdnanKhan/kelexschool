@extends('Admin.layout.master')
@section("page-css")
  <!-- DataTables -->
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
   <div class="col-md-4">

      <div class="card m-b-30 card-body ">
            <h3 class="card-title font-16 mt-0">Add New Record</h3>
            <form action="{{ route('add-bank')}}" id="add-bank" name="add_bank" method="post" accept-charset="utf-8">

                                <div class="form-group" style="margin:10px">

                                    <label for="exampleInputclass1">Bank Name</label><small class="req"> *</small>
                                    <input autofocus="" id="name" name="name" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                                    <small id="name_error" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group" style="margin:10px">

                                    <label for="exampleInputclass1">ACC Number</label><small class="req"> *</small>
                                    <input autofocus="" id="acc_number" name="acc_number" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                                    <small id="acc_number_error" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group" style="margin:10px">

                                    <label for="exampleInputclass1">ACC title</label><small class="req"> *</small>
                                    <input autofocus="" id="acc_title" name="acc_title" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                                    <small id="acc_title_error" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group" style="margin:10px">

                                    <label for="exampleInputclass1">BANK Logo</label><small class="req"> *</small>
                                    <input autofocus="" id="logo" name="logo" placeholder="" type="file" class="form-control" value="" autocomplete="off">
                                    <small id="logo_error" class="form-text text-danger"></small>
                                </div>
                                 <div class="form-group" style="margin:10px">

                                    <label for="exampleInputclass1">IS ACTIVE</label>
                                    <input id="is_active" name="is_active" type="checkbox" class="" value="1">
                                    <small id="is_active_error" class="form-text text-danger"></small>
                                </div>


                        <button type="submit" class="btn btn-primary btn-rounded btn-block waves-effect waves-light">Save</button>

                     @csrf
            </form>
      </div>
   </div>
   <div class="col-sm-7">
      <div class="card m-b-30 card-body">
         <h3 class="card-title font-16 mt-0">BANK LIST</h3>
         <div class="table-responsive">
         <table class="table table-striped table-bordered table-hover example dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
               <tr role="row">
               <th>BANK</th>
               <th>ACC NUMBER</th>
               <th>ACC TITLE</th>
               <th>LOGO</th>
               <th>STATUS</th>
               <th>Action</th>
               </tr>
            </thead>
            <tbody id="displaydata">
            @foreach($record as $row)
               <tr id="row{{$row->BANK_ID}}">
                  <td> {{$row->NAME}}</td>
                  <td> {{$row->ACC_TITLE}}</td>
                  <td> {{$row->ACC_NUMBER}}</td>
                  <td>
                        @php $logo = (trim($row->LOGO) == "") ? 'https://via.placeholder.com/60x60?text=LOGO' : asset('upload/banks/'.Session::get('CAMPUS_ID').'/'.$row->LOGO) @endphp
                                    <img src="{{$logo}}" class="img img-thumbnail" width="50%">
                  </td>
                  @php
                   $status = ($row->IS_ACTIVE == '1') ? '<span class="badge badge-primary">Active</span>' : '<span class="badge badge-warning">InActive</span>';
                  @endphp
                  <td> {!!$status!!}</td>
                  <td>
                     <button value="{{$row->BANK_ID}}" class="btn btn-primary pull-right btn-xs editbtn" > edit </button>

                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
         </div>
      </div>
   </div>
</div>
 <!-- Edit feecat using modal -->
 <div id="feecatEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Edit Section</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">

                     <form id="edit-bank" name="edit_bank" method="post" accept-charset="utf-8">
                         <div class="form-group" style="margin:10px">

                                    <label for="exampleInputclass1">Bank Name</label><small class="req"> *</small>
                                    <input autofocus="" id="edit_name" name="name" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                                    <small id="name_error" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group" style="margin:10px">

                                    <label for="exampleInputclass1">ACC Number</label><small class="req"> *</small>
                                    <input autofocus="" id="edit_acc_number" name="acc_number" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                                    <small id="acc_number_error" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group" style="margin:10px">

                                    <label for="exampleInputclass1">ACC title</label><small class="req"> *</small>
                                    <input autofocus="" id="edit_acc_title" name="acc_title" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                                    <small id="acc_title_error" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group" style="margin:10px">

                                    <label for="exampleInputclass1">BANK Logo</label><small class="req"> *</small>
                                    <input autofocus="" id="edit_logo" name="logo" placeholder="" type="file" class="form-control" value="" autocomplete="off">
                                    <small id="logo_error" class="form-text text-danger"></small>
                                </div>
                                 <div class="form-group" style="margin:10px">

                                    <label for="exampleInputclass1">IS ACTIVE</label>
                                    <input id="edit_is_active" name="is_active" type="checkbox" class="" value="1">
                                    <small id="is_active_error" class="form-text text-danger"></small>
                                    <input type="hidden" name="old_logo" id="old_logo">
                                </div>
                        <button type="submit" class="btn btn-primary btn-rounded btn-block waves-effect waves-light">Update</button>

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
      $('#DataTables_Table_0').DataTable({
          ordering : false
      });
        } );
     </script>

<Script>
    $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$('body').on('submit','#add-bank',function(e){
      e.preventDefault();
      var fdata = new FormData(this);
     try {
         $.ajax({
        url: '{{route("add-bank")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
              if(data.type == 1){
                  toastr.success(data.response,'Success');
                  setTimeout(function () {
                    location.reload();
                  },1000);
              }else{
                 toastr.error(data.response,'Error');
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
     } catch (error) {
        alert(error);
     }
    });

    $(document).on('click', '.editbtn',function () {
        // alert();
         bank_id = $(this).val();
        var classlist = "";
        var sectionlist = "";
        var classId ;
        var class_selected;
        $.ajax({
            url: '{{url("edit-bank")}}/'+bank_id,
            type: "GET",

            dataType:"json",
            success: function(data){

                record = data;
                    $('#edit_name').val(record.NAME);
                    $('#edit_acc_title').val(record.ACC_TITLE);
                    $('#edit_acc_name').val(record.ACC_NAME);
                     $('#edit_acc_number').val(record.ACC_NUMBER);
                     $('#old_logo').val(record.logo);
                    (record.IS_ACTIVE=="1") ? $('#edit_is_active').prop('checked', true) : $('#edit_is_active').prop('checked', false);

            }
           });
       $('#feecatEditModal').modal('show');
   });
  $('body').on('submit','#edit-bank',function(e){
      e.preventDefault();
      $('#acc_number_error').text('');
      $('#acc_title_error').text('');
      $('#name_error').text('');
    //   $('#SHIFT_err').text('');
      var fdata = new FormData(this);
      fdata.append('update',true);
      fdata.append('BANK_ID',bank_id);
      $.ajax({
        url: '{{url("update-bank")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
             if(data.type == 1){
                  toastr.success(data.response,'Success');
                  setTimeout(function () {
                    location.reload();
                  },1000);
                }else{
                    toastr.error(data.response,'Error');
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
