@extends('Admin.layout.master')
@section("page-css")
  <!-- DataTables -->
  <link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
   <div class="col-md-4">
      <div class="card m-b-30 card-body">
            <h3 class="card-title font-16 mt-0">Add {{Session::get('section')}}</h3>
               <form action="{{route('addsection')}}" id="addsection" name="sectionform" method="post" accept-charset="utf-8">
                   <div class="form-group">
                           <label for="exampleInputsection1">{{Session::get('section')}} Name </label><small class="req"> *</small>
                           <small id="Section_name_error" class="form-text text-danger"></small>
                           <input autofocus="" id="section" name="Section_name" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                           <span class="text-danger"></span>
                  </div>
                  <div class="form-group">
                     <label for="exampleInputsection1">Select {{Session::get('class')}} :  </label>
                     <small id="Classes_id_error" class="form-text text-danger"></small>
                     <select name="Classes_id" id="classes_id" class="form-control formselect required">
                        @foreach($classes as $class)
                           <option value="{{$class->Class_id}}">{{$class->Class_name}}</option>
                        @endforeach
                     </select>
                  </div>
                    
                        <button type="submit" class="btn btn-info btn-rounded btn-block waves-effect waves-light">Save</button>
                   
                     @csrf
            </form>
      </div>
   </div>
   <div class="col-md-8">
      <div class="card m-b-30 card-body">
         <h3 class="card-title font-16 mt-0">{{Session::get('section')}} List</h3>
         <div class="table-responsive">
         <table class="table table-striped table-bordered table-hover example dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
               <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Class: activate to sort column ascending" style="width: 255px;">{{Session::get('section')}}s</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Sections: activate to sort column ascending" style="width: 341px;">{{Session::get('class')}}</th>
                  <th class="text-right sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending" style="width: 222px;">Action</th>
               </tr>
            </thead>
            <tbody id="displaydata">
               @foreach($gsection as $section)
               <tr id="row{{$section->Section_id}}">
                  <td class="mailbox-name">
                     {{$section->Section_name}} 
                  </td>
                  <td>
                     {{$section->Class_name}}
                  </td>
                  <td class="mailbox-date pull-right">
                  <button value="{{$section->Section_id}}" class="btn btn-default btn-xs editbtn" > edit </button>
                  </td>
                  <!-- <td>
                  <button value="{{$section->Section_id}}" class="btn btn-default btn-xs deletebtn"> delete </button>
                  </td> -->
               </tr>
               @endforeach
            </tbody>
         </table>
         </div>
      </div>
   </div>
</div>
 <!-- Edit section using modal -->
 <div id="sectionEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Edit {{Session::get('section')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">

            <form action="{{route('updatesection')}}" id="editsection" name="sectionform" method="post" accept-charset="utf-8">
               
               <div class="box-body">
               
                     <div class="form-group" style="margin:10px">
                     <small id="Section_name_err" class="form-text text-danger"></small>
                        <input  id="sectionid"type="hidden" name="sectionid" value="">
                        <label for="exampleInputsection1">{{Session::get('section')}} Name </label><small class="req"> *</small>
                        <input autofocus="" id="sectionname" name="Section_name" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                        <span class="text-danger"></span>
                     </div>
                     <label for="exampleInputsection1">Select {{Session::get('class')}} :  </label>
                     <small id="Classes_id_err" class="form-text text-danger"></small>
                                 <select name="Classes_id" class="form-control formselect required" id="editClass_id">
                                 @foreach($classes as $class)
                        <option value="{{$class->Class_id}}">{{$class->Class_name}}</option>
                        @endforeach
                     </select>
                  
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
<Script>
    $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$('body').on('submit','#addsection',function(e){
      e.preventDefault();
      $('#Section_name_error').text('');
      $('#Classes_id_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("addsection")}}',
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
    $(document).on('click', '.editbtn',function () {
        var sectionid = $(this).val();
        $.ajax({
            url: '{{url("editsection")}}',
            type: "GET",
            data: {
               sectionid:sectionid
            }, 
            dataType:"json",
            success: function(data){
               console.log(data);
               
          for(i=0;i<data.length;i++){
            $('#sectionid').val(data[i].Section_id);
            $('#sectionname').val(data[i].Section_name);
            $('#editClass_id').val(data[i].Class_id).change();
          }
            }
        });
       $('#sectionEditModal').modal('show');
   });
  $('body').on('submit','#editsection',function(e){
      e.preventDefault();
      $('#Section_name_err').text('');
      $('#Classes_id_err').text('');
      var fdata = new FormData(this);

      $.ajax({
        url: '{{url("updatesection")}}',
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
   //  $('body').on('click', '.deletebtn',function () {
   //      var sectionid = $(this).val();
   //      $.ajax({
   //          url: '{{url("deletesection")}}',
   //          type: "GET",
   //          data: {
   //             sectionid:sectionid
   //          }, 
   //          dataType:"json",
   //          success: function(data){
   //             alert("deleted");
   //             $('#row' + data).remove();
               
              
   //          }
   //      });
   //    });

</script>
   
@endsection