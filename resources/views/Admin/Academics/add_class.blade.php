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
            <h3 class="card-title font-16 mt-0">Add {{Session::get('class')}}</h3>
            <form action="{{route('addclass')}}" id="addclass" name="classform" method="post" accept-charset="utf-8">
                <div class="form-group">
                  <label for="exampleInputclass1">{{Session::get('class')}} Name </label><small class="req"> *</small>
                     <small id="class_name_error" class="form-text text-danger"></small>
                     <input autofocus="" id="class" name="class_name" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                     <span class="text-danger"></span>
               </div>
               <button type="submit" class="btn btn-info btn-rounded btn-block waves-effect waves-light">Save</button>
               @csrf
            </form>
      </div>
   </div>
   <div class="col-md-6">
      <div class="card m-b-30 card-body">
         <h3 class="card-title font-16 mt-0">{{Session::get('class')}} List</h3>
         <div class="table-responsive">
           <table class="table table-striped table-bordered table-hover example dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
               <tr role="row">
                  <th>Class</th>
                  <th class="text-right">Action</th>
               </tr>
            </thead>
            <tbody id="displaydata">
               @foreach($gclass as $class)
               <tr id="row{{$class->Class_id}}">
                  <td class="mailbox-name"> {{$class->Class_name}}</td>
                  <td class="mailbox-date pull-right">
                     <button value="{{$class->Class_id}}" class="btn btn-default btn-xs editbtn" > edit </button>
                     <!-- <button value="{{$class->Class_id}}" class="btn btn-default btn-xs deletebtn"> delete </button>
                      -->
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
         </div>
         </div>
        
      </div>
   </div>
</div>
 <!-- Edit class using modal -->
<div id="classEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Edit {{Session::get('class')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">
                     <form action="{{route('updateclass')}}" id="editclass" name="classform" method="post" accept-charset="utf-8">

                        <div class="box-body">
                           
                              <div class="form-group" style="margin:10px">
                              <small id="class_name_err" class="form-text text-danger"></small>
                                 <input  id="classid"type="hidden" name="classid" value="">
                                 <label for="exampleInputclass1">{{Session::get('class')}} Name </label><small class="req"> *</small>
                                 <input autofocus="" id="classname" name="class_name" placeholder="" type="text" class="form-control" value="" autocomplete="off">
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
$('body').on('submit','#addclass',function(e){
      e.preventDefault();
      $('#class_name_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("addclass")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               console.log(data)
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
        var classid = $(this).val();
        $.ajax({
            url: '{{url("editclass")}}',
            type: "GET",
            data: {
               classid:classid
            }, 
            dataType:"json",
            success: function(data){
               console.log(data);
               
          for(i=0;i<data.length;i++){
            $('#classid').val(data[i].Class_id);
            $('#classname').val(data[i].Class_name);
          }
            }
        });
       $('#classEditModal').modal('show');
   });
  $(document).on('submit','#editclass',function(e){
      e.preventDefault();
      $('#class_name_err').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("updateclass")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               console.log(data);
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
    ///////////////////////////// Delete classs /////////////////////
   //  $('body').on('click', '.deletebtn',function () {
   //      var classid = $(this).val();
   //      $.ajax({
   //          url: '{{url("deleteclass")}}',
   //          type: "GET",
   //          data: {
   //             classid:classid
   //          }, 
   //          dataType:"json",
   //          success: function(data){
   //             alert("deleted");
   //             $('#row' + data).remove();
             
              
   //          }
   //      });
   //    });

</script>
   
@endSection