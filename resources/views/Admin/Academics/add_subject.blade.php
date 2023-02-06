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
         <h3 class="card-title font-16 mt-0">Add Subjects</h3>
         <form  action="{{ route('addcampus')}}" id="addsubject" method="post" accept-charset="utf-8">
            
              @csrf                           
               <div class="form-group">
                  <label for="exampleInputsubject1">Subject Name</label><small class="req"> *</small>
                  <small id="subject_name_error" class="form-text text-danger"></small>
                  <input autofocus="" id="sbjname" name="subject_name" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="exampleInputEmail1">Subject Code</label>
                  <small id="subject_code_error" class="form-text text-danger"></small>
                  <input id="sbjcode" name="subject_code" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <button type="submit" class="btn btn-info btn-rounded btn-block waves-effect waves-light">Save</button>
         </form>
      </div>
   </div>
   <div class="col-md-6">
      <div class="card m-b-30 card-body">
         <h3 class="card-title font-16 mt-0">Subjects List</h3>
         <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover example dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                     <thead>
                        <tr role="row">
                           <th >Subject</th>
                           <th >Subject Code</th>
                           <th >Instuition Type</th>
                           <th class="text-right" colspan="2">Action</th>
                        </tr>
                     </thead>
                     <tbody id="displaydata">
                           @foreach($gsubject as $subject)
                           <tr id="row{{$subject->SUBJECT_ID}}">
                              <td class="mailbox-name"> {{$subject->SUBJECT_NAME}}</td>
                              <td class="mailbox-name"> {{$subject->SUBJECT_CODE}}</td>
                              <td class="mailbox-name"> <?= $subject->TYPE=='0'?'Learning Instution':'School' ?></td>
                              <td class="mailbox-date pull-right">
                                 <button value="{{$subject->SUBJECT_ID}}" class="btn btn-default btn-xs editbtn" > edit </button>
                              </td>
                              <!-- <td>
                                 <button value="{{$subject->SUBJECT_ID}}" class="btn btn-default btn-xs deletebtn"> delete </button>
                              </td> -->
                           </tr>
                           @endforeach
                        </tbody>
                  </table>
                  </div>
                
           
        
      </div>
   </div>
</div>
                        <!-- end row -->
<!-- Edit Subject Using Modal -->
<div id="SubjectEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Edit Session/Batches</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">
                     <form action="{{route('updatesubject')}}" id="editsubject" name="classform" method="post" accept-charset="utf-8">
            <div class="box-body">
               <div class="form-group" style="margin:10px">
             
                  <input  id="subject_id"type="hidden" name="subject_id" value="">
                  <label for="exampleInputsubject1">Subject Name </label><small class="req"> *</small>
                  <small id="subject_name_err" class="form-text text-danger"></small>
                  <input autofocus="" id="subject_name" name="subject_name" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group" style="margin:10px">
                  <label for="exampleInputclass1">Subject Code </label><small class="req"> *</small>
                  <small id="subject_code_err" class="form-text text-danger"></small>
                  <input autofocus="" id="subject_code" name="subject_code" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
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
 <!-- content -->
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
$('body').on('submit','#addsubject',function(e){
      e.preventDefault();
      $('#subject_name_error').text('');
      $('#subject_code_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("addsubject")}}',
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
        var subjectid = $(this).val();
        $.ajax({
            url: '{{url("editsubject")}}',
            type: "GET",
            data: {
               subjectid:subjectid
            }, 
            dataType:"json",
            success: function(data){
             //  console.log(data);
               
          for(i=0;i<data.length;i++){
            $('#subject_id').val(data[i].SUBJECT_ID);
            $('#subject_name').val(data[i].SUBJECT_NAME);
            $('#subject_code').val(data[i].SUBJECT_CODE);
          }
            }
        });
       $('#SubjectEditModal').modal('show');
   });
  $('body').on('submit','#editsubject',function(e){
      e.preventDefault();
      $('#Section_name_err').text('');
      $('#subject_code_err').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("updatesubject")}}',
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
   //      var subjectid = $(this).val();
   //      $.ajax({
   //          url: '{{url("deletesubject")}}',
   //          type: "GET",
   //          data: {
   //             subjectid:subjectid
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