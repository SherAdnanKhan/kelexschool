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
         <h3 class="card-title font-16 mt-0">Add {{Session::get('session')}}</h3>
         <form  action="{{ route('addsession-batch')}}" id="addsession-batch" method="post" accept-charset="utf-8">
            <div class="box-body">
              @csrf
               <div class="form-group">
                  <label for="exampleInputSB1">{{Session::get('session')}} Name</label><small class="req"> *</small>
                  <small id="sb_name_error" class="form-text text-danger"></small>
                  <input autofocus="" name="sb_name" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="exampleInputEmail1">Start date</label>
                  <small id="start_date_error" class="form-text text-danger"></small>
                  <input name="start_date" placeholder="" type="date" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="exampleInputEmail1">End Date</label>
                  <small id="end_date_error" class="form-text text-danger"></small>
                  <input  name="end_date" placeholder="" type="date" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group">
                <!-- <label for="Sins">Please Select:</label><br> -->
                <small id="type_error" class="form-text text-danger"></small>
                <label class="radio-inline" style="display: none">
                <?php $campus=Session::get('CAMPUS');?>
                @if($campus->TYPE=='school')
                    <input type="radio" name="type" value="1" style=" margin: 10px;" checked="true"> 
                @else
                    <input type="radio" name="type" value="0" style=" margin: 10px;" checked="true"> 
                @endif
                </label>
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
         <h3 class="card-title font-16 mt-0">{{Session::get('session')}} List</h3>
         <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover example dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
               <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Subject: activate to sort column ascending" style="width: 208px;">{{Session::get('session')}} </th>
                  <th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Subject Code: activate to sort column ascending" style="width: 236px;" aria-sort="descending">START DATE</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Subject Type: activate to sort column ascending" style="width: 239px;">END DATE</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Subject Type: activate to sort column ascending" style="width: 239px;">TYPE</th>
                  <th class="text-right no-print sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending" style="width: 230px;">Action</th>
               </tr>
            </thead>
            <tbody id="displaydata">
               @foreach($gsession as $session)
               <tr id="row{{$session->SB_ID}}">
                  <td class="mailbox-name"> {{$session->SB_NAME}}</td>
                  <td class="mailbox-name"> {{$session->START_DATE}}</td>
                  <td class="mailbox-name"> {{$session->END_DATE}}</td>
                  <td class="mailbox-name"> {{$session->TYPE==1?'Session':'Batch'}}</td>
                  <td class="mailbox-date pull-right">
                     <button value="{{$session->SB_ID}}" class="btn btn-default btn-xs editbtn" > edit </button>
                  </td>
                  <!-- <td>
                     <button value="{{$session->SB_ID}}" class="btn btn-default btn-xs deletebtn"> delete </button>
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
<!-- edit Session Batch modal  -->
<div id="sessionEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Edit {{Session::get('session')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">
            <form action="{{route('updatesession-batch')}}" id="editsession" name="classform" method="post" accept-charset="utf-8">
         @csrf
         <div class="box-body">
            <div class="form-group">
            <input  id="sb_id"type="hidden" name="sb_id" value="">
                  <label for="exampleInputSB1">{{Session::get('session')}} Name</label><small class="req"> *</small>
                  <small id="sb_name_err" class="form-text text-danger"></small>
                  <input autofocus="" id="sb_name" name="sb_name" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="exampleInputEmail1">Start date</label>
                  <small id="start_date_err" class="form-text text-danger"></small>
                  <input id="start_date" name="start_date" placeholder="" type="date" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="exampleInputEmail1">End Date</label>
                  <small id="end_date_err" class="form-text text-danger"></small>
                  <input id="end_date" name="end_date" placeholder="" type="date" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group">
                <label for="Sins">Please {{Session::get('session')}}:</label><br>
                <label class="radio-inline">
                <small id="type_err" class="form-text text-danger"></small>
                <?php $campus=Session::get('CAMPUS');?>
                @if($campus->TYPE=='school')
                <input type="radio" id="session" name="type" value="1" style=" margin: 10px;" > Session
                @else
                <input type="radio" id="batch" name="type" value="0" style=" margin: 10px;"> Batch
                @endif
                </label>
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

$('body').on('submit','#addsession-batch',function(e){
      e.preventDefault();
      $('#sb_name_error').text('');
      $('#start_date_error').text('');
      $('#end_date_error').text('');
      $('#type_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("addsession-batch")}}',
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
        var sessionid = $(this).val();
        $.ajax({
            url: '{{url("editsession-batch")}}',
            type: "GET",
            data: {
               sessionid:sessionid
            },
            dataType:"json",
            success: function(data){
             //  console.log(data);

          for(i=0;i<data.length;i++){
            $('#sb_id').val(data[i].SB_ID);
            $('#sb_name').val(data[i].SB_NAME);
            $('#start_date').val(data[i].START_DATE);
            $('#end_date').val(data[i].END_DATE);
            (data[i].TYPE=="1")?$('#session').prop('checked', true):$('#batch').prop('checked', true);
          }
            }
        });
       $('#sessionEditModal').modal('show');
   });
  $('body').on('submit','#editsession',function(e){
      e.preventDefault();
      $('#sb_name_err').text('');
      $('#start_date_err').text('');
      $('#end_date_err').text('');
      $('#type_err').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("updatesession-batch")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               console.log(data)

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
   //      var sessionid = $(this).val();
   //      $.ajax({
   //          url: '{{url("deletesession-batch")}}',
   //          type: "GET",
   //          data: {
   //             sessionid:sessionid
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
