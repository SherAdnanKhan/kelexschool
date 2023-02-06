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
         <h3 class="card-title font-16 mt-0">Add Grade</h3>
         <form  action="{{ route('addgrade')}}" id="addgrade" method="post" accept-charset="utf-8">
            <div class="box-body">
              @csrf
               <div class="form-group">
                  <label for="Example">Grade Name</label><small class="req"> *</small>
                  <small id="GRADE_NAME_error" class="form-text text-danger"></small>
                  <input autofocus="" name="GRADE_NAME" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="GRADEpleInputEmail1">Marks Range From</label>
                  <small id="FROM_MARKS_error" class="form-text text-danger"></small>
                  <input name="FROM_MARKS" placeholder="" type="number" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="GRADEpleInputEmail1">Marks Range To</label>
                  <small id="TO_MARKS_error" class="form-text text-danger"></small>
                  <input  name="TO_MARKS" placeholder="" type="number" class="form-control" value="" autocomplete="off">
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
         <h3 class="card-title font-16 mt-0">GRADE List</h3>
         <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover GRADEple dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
               <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Subject: activate to sort column ascending" style="width: 208px;">Grade </th>
                  <th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Subject Code: activate to sort column ascending" style="width: 236px;" aria-sort="descending">Range From</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Subject Type: activate to sort column ascending" style="width: 239px;">Range To</th>
                  <th class="text-right no-print sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending" style="width: 230px;">Action</th>
               </tr>
            </thead>
            <tbody id="displaydata">
               @foreach($gGRADE as $GRADE)
               <tr id="row{{$GRADE->GRADE_ID}}">
                  <td class="mailbox-name"> {{$GRADE->GRADE_NAME}}</td>
                  <td class="mailbox-name"> {{$GRADE->FROM_MARKS}}</td>
                  <td class="mailbox-name"> {{$GRADE->TO_MARKS}}</td>
                  <td class="mailbox-date pull-right">
                     <button value="{{$GRADE->GRADE_ID}}" class="btn btn-default btn-xs editbtn" > Edit </button>
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
</div>
<!-- edit GRADE modal  -->
<div id="gradeEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Edit Grades</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">
            <form action="{{route('updategrade')}}" id="editgrade" name="classform" method="post" accept-charset="utf-8">
         @csrf
         <div class="box-body">
            <div class="form-group">
            <input  id="GRADE_ID"type="hidden" name="GRADE_ID" value="">
                  <label for="Example">GRADE Name</label><small class="req"> *</small>
                  <small id="GRADE_NAME_err" class="form-text text-danger"></small>
                  <input autofocus="" id="GRADE_NAME" name="GRADE_NAME" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="ExampleInputEmail1">Marks Range From</label>
                  <small id="FROM_MARKS_err" class="form-text text-danger"></small>
                  <input id="FROM_MARKS" name="FROM_MARKS" placeholder="" type="number" class="form-control" value="" autocomplete="off">
                  <span class="text-danger"></span>
               </div>
               <div class="form-group"><br>
                  <label for="ExampleInputEmail1">Marks Range To</label>
                  <small id="TO_MARKS_err" class="form-text text-danger"></small>
                  <input id="TO_MARKS" name="TO_MARKS" placeholder="" type="number" class="form-control" value="" autocomplete="off">
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
        <!-- Buttons GRADEples -->
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

$('body').on('submit','#addgrade',function(e){
      e.preventDefault();
      $('#GRADE_NAME_error').text('');
      $('#FROM_MARKS_error').text('');
      $('#TO_MARKS_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("addgrade")}}',
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
               toastr.warning('To MARKS Should be less than from MARKS', 'Notice');
              }
              else
              {
              toastr.error('Already Another GRADE Exist', 'Notice');
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
        var GRADE_ID = $(this).val();
        $.ajax({
            url: '{{url("editgrade")}}',
            type: "GET",
            data: {
               GRADE_ID:GRADE_ID
            },
            dataType:"json",
            success: function(data){
             //  console.log(data);

          for(i=0;i<data.length;i++){
            $('#GRADE_ID').val(data[i].GRADE_ID);
            $('#GRADE_NAME').val(data[i].GRADE_NAME);
            $('#FROM_MARKS').val(data[i].FROM_MARKS);
            $('#TO_MARKS').val(data[i].TO_MARKS);
          }
            }
        });
       $('#gradeEditModal').modal('show');
   });
  $('body').on('submit','#editgrade',function(e){
      e.preventDefault();
      $('#GRADE_NAME_err').text('');
      $('#FROM_MARKS_err').text('');
      $('#TO_MARKS_err').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("updategrade")}}',
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
               toastr.warning('To MARKS Should be less than from MARKS', 'Notice');
              }
              else
              {
              toastr.error('Already Another GRADE Exist in this range marks', 'Notice');
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
