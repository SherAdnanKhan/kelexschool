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
         <h3 class="card-title font-16 mt-0">Add Exam</h3>
         <form  action="{{ route('addexam')}}" id="addexam" method="post" accept-charset="utf-8">
            <div class="box-body">
              @csrf
              <div class="form-group">
                     <label for="">{{Session::get('session')}}</label>
                        <small class="req"> *</small>
                        <select name="SESSION_ID" class="form-control formselect required" placeholder="Select Session"
                          >

                           <option value="0" disabled selected>Select
                           {{Session::get('session')}}*</option>
                           @foreach($sessions as $session)
                           <option  value="{{ $session->SB_ID }}">
                              {{ ucfirst($session->SB_NAME) }}</option>
                           @endforeach
                        </select>
                     <small id="SESSION_ID_error" class="form-text text-danger"></small>
                </div>
               <div class="form-group">
                  <label for="exampleInputSB1">Exam Name</label><small class="req"> *</small>
                  <small id="EXAM_NAME_error" class="form-text text-danger"></small>
                  <input autofocus="" name="EXAM_NAME" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="exampleInputEmail1">Start date</label>
                  <small id="START_DATE_error" class="form-text text-danger"></small>
                  <input name="START_DATE" placeholder="" type="date" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="exampleInputEmail1">End Date</label>
                  <small id="END_DATE_error" class="form-text text-danger"></small>
                  <input  name="END_DATE" placeholder="" type="date" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
             
             
            </div>
            <div class="box-footer">
               <button type="submit" class="btn btn-info btn-rounded btn-block waves-effect waves-light">Save</button>
            </div>
         </form>
      </div>
   </div>
   <div class="col-md-8">
      <div class="card m-b-30 card-body">
         <h3 class="card-title font-16 mt-0">Exam List</h3>
         <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover example dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
               <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Subject: activate to sort column ascending" style="width: 208px;">Exam </th>
                  <th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Subject Code: activate to sort column ascending" style="width: 236px;" aria-sort="descending">START DATE</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Subject Type: activate to sort column ascending" style="width: 239px;">END DATE</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Subject Type: activate to sort column ascending" style="width: 239px;">{{Session::get('session')}}</th>
                  <th class="text-right no-print sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending" style="width: 230px;">Action</th>
               </tr>
            </thead>
            <tbody id="displaydata">
               @foreach($gexam as $exam)
               <tr id="row{{$exam->EXAM_ID}}">
                  <td class="mailbox-name"> {{$exam->EXAM_NAME}}</td>
                  <td class="mailbox-name"> {{$exam->START_DATE}}</td>
                  <td class="mailbox-name"> {{$exam->END_DATE}}</td>
                  <td class="mailbox-name">  @foreach($sessions as $row)
                                 <?= $exam->SESSION_ID==$row->SB_ID?ucfirst($row->SB_NAME):'' ?>
                                    @endforeach</td>
                  <td class="mailbox-date pull-right">
                     <button value="{{$exam->EXAM_ID}}" class="btn btn-default btn-xs editbtn" > edit </button>
                  </td>
                  <!-- <td>
                     <button value="{{$exam->EXAM_ID}}" class="btn btn-default btn-xs deletebtn"> delete </button>
                  </td> -->
               </tr>
               @endforeach
            </tbody>
         </table>
         </div>
         </div>
         </div>
      </div>
   </div>
</div>
<!-- edit Exam modal  -->
<div id="sessionEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Edit Exames</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">
            <form action="{{route('updateexam')}}" id="editexam" name="classform" method="post" accept-charset="utf-8">
         @csrf
         <div class="box-body">
         <div class="form-group">
                     <label for="">{{Session::get('session')}}</label>
                        <small class="req"> *</small>
                        <select name="SESSION_ID" class="form-control formselect required" placeholder="Select Session"
                           id="SESSION_ID">
                           <option value="0" disabled selected>Select
                           {{Session::get('session')}}*</option>
                           @foreach($sessions as $session)
                           <option  value="{{ $session->SB_ID }}">
                              {{ ucfirst($session->SB_NAME) }}</option>
                           @endforeach
                        </select>
                     <small id="SESSION_ID_error" class="form-text text-danger"></small>
                </div>
            <div class="form-group">
            <input  id="EXAM_ID"type="hidden" name="EXAM_ID" value="">
                  <label for="exampleInputSB1">Exam Name</label><small class="req"> *</small>
                  <small id="EXAM_NAME_err" class="form-text text-danger"></small>
                  <input autofocus="" id="EXAM_NAME" name="EXAM_NAME" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="exampleInputEmail1">Start date</label>
                  <small id="START_DATE_err" class="form-text text-danger"></small>
                  <input id="START_DATE" name="START_DATE" placeholder="" type="date" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="exampleInputEmail1">End Date</label>
                  <small id="END_DATE_err" class="form-text text-danger"></small>
                  <input id="END_DATE" name="END_DATE" placeholder="" type="date" class="form-control" value="" autocomplete="off">
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

$('body').on('submit','#addexam',function(e){
      e.preventDefault();
      $('#EXAM_NAME_error').text('');
      $('#START_DATE_error').text('');
      $('#END_DATE_error').text('');
      $('#SESSION_ID_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("addexam")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               console.log(data);
               if(data==true){
               toastr.success('success Added', 'Notice');
                setTimeout(function(){location.reload();},1000);
              }
              else if(data=='wrongselect')
              {
               toastr.warning('To Date Should be not be date before Start date', 'Notice');
              }
              else
              {
              toastr.error('Already Another Exam Exist of this SESSION on Paticular dates', 'Notice');
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
        var EXAM_ID = $(this).val();
        $.ajax({
            url: '{{url("editexam")}}',
            type: "GET",
            data: {
               EXAM_ID:EXAM_ID
            },
            dataType:"json",
            success: function(data){
             //  console.log(data);

          for(i=0;i<data.length;i++){
            $('#EXAM_ID').val(data[i].EXAM_ID);
            $('#EXAM_NAME').val(data[i].EXAM_NAME);
            $('#START_DATE').val(data[i].START_DATE);
            $('#END_DATE').val(data[i].END_DATE);
            $('#SESSION_ID').val(data[i]["SESSION_ID"]).change();
          }
            }
        });
       $('#sessionEditModal').modal('show');
   });
  $('body').on('submit','#editexam',function(e){
      e.preventDefault();
      $('#EXAM_NAME_err').text('');
      $('#START_DATE_err').text('');
      $('#END_DATE_err').text('');
      $('#SESSION_ID_err').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("updateexam")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               console.log(data)
               if(data==true){
               toastr.success('Successfully Updated', 'Notice');
                setTimeout(function(){location.reload();},1000);
              }
              else if(data=='wrongselect')
              {
               toastr.warning('To Date Should be not be date before Start date', 'Notice');
              }
              else
              {
              toastr.error('Already Another Exam Exist of this SESSION on Paticular dates', 'Notice');
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
   //  $('body').on('click', '.deletebtn',function () {
   //      var EXAM_ID = $(this).val();
   //      $.ajax({
   //          url: '{{url("deleteexam")}}',
   //          type: "GET",
   //          data: {
   //             EXAM_ID:EXAM_ID
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
