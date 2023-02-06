@extends('Admin.layout.master')
@section("page-css")
  <!-- DataTables -->
  <link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section("content")
<div class="row">
   <div class="col-md-4">
      <div class="card m-b-30 card-body">
            <h3 class="card-title font-16 mt-0">Add Subject group Name</h3>
            <form action="{{route('addsgroup')}}" id="addsgroup" name="classform" method="post" accept-charset="utf-8">
                <div class="form-group">
                  <label for="exampleInputclass1">Group Name </label><small class="req"> *</small>
                     <small id="GROUP_NAME_error" class="form-text text-danger"></small>
                     <input autofocus="" id="GROUP_NAME" name="GROUP_NAME" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                     <span class="text-danger"></span>
               </div>
               <button type="submit" class="btn btn-info btn-rounded btn-block waves-effect waves-light">Save</button>
               @csrf
            </form>
      </div>
   </div>
   <div class="col-md-6">
      <div class="card m-b-30 card-body">
         <h3 class="card-title font-16 mt-0">Subject Group List</h3>
         <div class="table-responsive">
           <table class="table table-striped table-bordered table-hover example dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
               <tr role="row">
                  <th>Subject group name</th>
                  <th class="text-right">Action</th>
               </tr>
            </thead>
            <tbody id="displaydata">
               @foreach($subjectgroup as $subjectg)
               <tr id="row{{$subjectg->GROUP_ID}}">
                  <td class="mailbox-name"> {{$subjectg->GROUP_NAME}}</td>
                  <td class="mailbox-date pull-right">
                     <button value="{{$subjectg->GROUP_ID}}" class="btn btn-default btn-xs editbtn" > edit </button> 
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
         </div>
        
      </div>
   </div>
</div>
 <!-- Edit class using modal -->
<div id="subjectgEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Edit SUBJECT GROUP NAME</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">
                     <form action="{{route('updatesgroup')}}" id="editsgroup" name="classform" method="post" accept-charset="utf-8">

                        <div class="box-body">
                           
                              <div class="form-group" style="margin:10px">
                              <small id="GROUP_NAME_err" class="form-text text-danger"></small>
                                 <input  id="editGROUP_ID"type="hidden" name="GROUP_ID" value="">
                                 <label for="exampleInputclass1">Subject Group Name </label><small class="req"> *</small>
                                 <input autofocus="" id="editGROUP_NAME" name="GROUP_NAME" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                                 <span class="text-danger"></span>
                              </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                     </div>
                           @csrf
                     </form>

                  
                   
               </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
         </div><!-- /.modal -->
   </div>



 <!-- Edit class using modal -->
</div>
</div>  
</div>
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
   
    $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$('body').on('submit','#addsgroup',function(e){
      e.preventDefault();
      $('#GROUP_NAME_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("addsgroup")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               toastr.success('success added', 'Notice');
                setTimeout(function(){location.reload();},1000);
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
    ////////////////////// EDit class /////////////////////////////////////////
    $('body').on('click', '.editbtn',function () {
        var GROUP_ID = $(this).val();
        $.ajax({
            url: '{{url("editsgroup")}}',
            type: "GET",
            data: {
               GROUP_ID:GROUP_ID
            }, 
            dataType:"json",
            success: function(data){
               console.log(data);
               
          for(i=0;i<data.length;i++){
            $('#editGROUP_ID').val(data[i].GROUP_ID);
            $('#editGROUP_NAME').val(data[i].GROUP_NAME);
          }
            }
        });
       $('#subjectgEditModal').modal('show');
   });
  $(document).on('submit','#editsgroup',function(e){
      e.preventDefault();
      $('#GROUP_NAME_err').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("updatesgroup")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               toastr.success('success updated', 'Notice');
                setTimeout(function(){location.reload();},1000);
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
   
@endSection