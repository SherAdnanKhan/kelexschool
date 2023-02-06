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
            <h3 class="card-title font-16 mt-0">Add Fee Category</h3>
            <form action="{{ route('addfeecategory')}}" id="addfeecategory" name="sectionform" method="post" accept-charset="utf-8">
                                {{-- <div class="form-group">
                                    <label for="">Class</label>
                                       <small class="req"> *</small>
                                       <select name="CLASS_ID" class="form-control formselect required" placeholder="Select Class"
                                          id="class_id">
                                          <option value="0" disabled selected>Select
                                             Class*</option>
                                          @foreach($classes as $class)
                                          <option  value="{{ $class->Class_id }}">
                                             {{ ucfirst($class->Class_name) }}</option>
                                          @endforeach
                                    </select>
                                    <small id="CLASS_ID_error" class="form-text text-danger"></small>
                                </div> --}}
                                {{-- <div class="form-group">
                                       <label for="">Section</label>
                                          <small class="req"> *</small>
                                          <select name="SECTION_ID" class="form-control formselect required" placeholder="Select Section" id="sectionid" >
                                       </select>
                                       <small id="SECTION_ID_error" class="form-text text-danger"></small>
                                </div> --}}
                                <div class="form-group" style="margin:10px">

                                    <label for="exampleInputclass1">Fee Name</label><small class="req"> *</small>
                                    <input autofocus="" id="CATEGORY" name="CATEGORY" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                                    <small id="CATEGORY_error" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label for="SHIFT"> Shift:</label><br>
                                    <label class="radio-inline">

                                    <input type="radio" id="morning" name="SHIFT" value="1" style=" margin: 10px;" checked > Morning
                                    <input type="radio" id="evening" name="SHIFT" value="0" style=" margin: 10px;"> Evening
                                    </label>
                                    <small id="SHIFT_error" class="form-text text-danger"></small>
                                </div>

                        <button type="submit" class="btn btn-info btn-rounded btn-block waves-effect waves-light">Save</button>

                     @csrf
            </form>
      </div>
   </div>
   <div class="col-sm-7">
      <div class="card m-b-30 card-body">
         <h3 class="card-title font-16 mt-0">Fee Catergory List</h3>
         <div class="table-responsive">
         <table class="table table-striped table-bordered table-hover example dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
               <tr role="row">
               <th>Fee Name</th>
               {{-- <th>Classes</th>
               <th>Sections</th> --}}
               <th>Shift</th>
               <th>Action</th>
               </tr>
            </thead>
            <tbody id="displaydata">
            @foreach($getfeecat as $getfc)
               <tr id="row{{$getfc->FEE_CAT_ID}}">
                  <td> {{$getfc->CATEGORY}}</td>
                  {{-- <td> {{$getfc->Class_name}}</td>
                  <td> {{$getfc->Section_name}}</td> --}}
                  <td> {{$getfc->SHIFT==1?'Morning':'Evening'}}</td>
                  <td>
                     <button value="{{$getfc->FEE_CAT_ID}}" class="btn btn-default pull-right btn-xs editbtn" > edit </button>

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
                        <h5 class="modal-title mt-0" id="myModalLabel">Edit Fee Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">

                     <form action="{{ route('updatefeecategory')}}" id="editfeecategory" name="sectionform" method="post" accept-charset="utf-8">
                                {{-- <div class="form-group">
                                    <label for="">Class</label>
                                       <small class="req"> *</small>
                                       <select name="CLASS_ID" class="form-control formselect required" placeholder="Select Class"
                                          id="editclass_id">
                                          <option value="0" disabled selected>Select
                                             Class*</option>
                                    </select>
                                    <small id="CLASS_ID_err" class="form-text text-danger"></small>
                                </div> --}}
                                {{-- <div class="form-group">
                                       <label for="">Section</label>
                                          <small class="req"> *</small>
                                          <select name="SECTION_ID" class="form-control formselect required" placeholder="Select Section" id="editsectionid" >
                                          <option value="0" disabled selected>Select
                                             Class*</option>
                                       </select>
                                       <small id="SECTION_ID_err" class="form-text text-danger"></small>
                                </div> --}}
                                <div class="form-group" style="margin:10px">

                                    <label for="exampleInputclass1">Fee Name</label><small class="req"> *</small>
                                    <input type="hidden" id="editFEE_CAT_ID" name="FEE_CAT_ID" value="">
                                    <input autofocus="" id="editCATEGORY" name="CATEGORY" placeholder="" type="text" class="form-control" value="" autocomplete="off">
                                    <small id="CATEGORY_err" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label for="SHIFT"> Shift:</label><br>
                                    <label class="radio-inline">

                                    <input type="radio" id="editmorning" name="SHIFT" value="1" style=" margin: 10px;"  > Morning
                                    <input type="radio" id="editevening" name="SHIFT" value="0" style=" margin: 10px;"> Evening
                                    </label>
                                    <small id="SHIFT_err" class="form-text text-danger"></small>
                                </div>

                        <button type="submit" class="btn btn-info btn-rounded btn-block waves-effect waves-light">Update</button>

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
        $('#editclass_id').on('change', function () {
                let id = $(this).val();
                $('#editsectionid').empty();
                $('#editsectionid').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'getsection/' + id,
                success: function (response) {
                var response = JSON.parse(response);
                //console.log(response);
                $('#editsectionid').empty();
                $('#editsectionid').append(`<option value="0" disabled selected>Select Section*</option>`);
                response.forEach(element => {
                    $('#editsectionid').append(`<option value="${element['Section_id']}">${element['Section_name']}</option>`);
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
$('body').on('submit','#addfeecategory',function(e){
      e.preventDefault();
      $('#CLASS_ID_error').text('');
      $('#SECTION_ID_error').text('');
      $('#CATEGORY_error').text('');
      $('#SHIFT_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("addfeecategory")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
              console.log(data)
              var type = data.SHIFT==1?'Morning':'Evening';
                $('#displaydata').append(`
                     <tr id="row`+data.FEE_CAT_ID+`">
                        <td class="mailbox-name">` + data.CATEGORY + `</td>
                        <td class="mailbox-name">` + type + `</td>

                        <td class="mailbox-date pull-right">
                     <button value="`+data.FEE_CAT_ID+`" class="btn btn-primary btn-xs editbtn" > Edit </button>
                          </td>
                      </tr>`)
                      $("#addfeecategory").get(0).reset();
                      toastr.success('Fee category Added Successfully..');
                      setTimeout(function() {
                         location.reload();
                      },1000)

                     //  $('#DataTables_Table_0').DataTable().destroy().draw();
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
        var feecatid = $(this).val();
        var classlist = "";
        var sectionlist = "";
        var classId ;
        var class_selected;
        $.ajax({
            url: '{{url("editfeecategory")}}',
            type: "GET",
            data: {
               feecatid:feecatid
            },
            dataType:"json",
            success: function(data){
              // console.log(data);
        //   for();
          feedata = data.record;
          classes = data.classes;
          console.log(classes);
          sections = data.sections;
          for(i=0;i<feedata.length;i++){
            classId = feedata[i].CLASS_ID;
            $('#editFEE_CAT_ID').val(feedata[i].FEE_CAT_ID);
            $('#editCATEGORY').val(feedata[i].CATEGORY);
            (feedata[i].TYPE=="1")?$('#editmorning').prop('checked', true):$('#editevening').prop('checked', true);
          }
          for(k=0;k<classes.length;k++)
          {
                if(classId == classes[k]['Class_id']){
                    class_selected = "selected";
                }else{
                  class_selected = "";
                }
            // classlist += '<option value="'+classes[k]['Class_id']+'" '+class_selected+'>'+classes[k]['Class_name']+'</option>';
          }
        //   sectionlist += '<option value="'+sections['Section_id']+'">'+sections['Section_name']+'</option>"';
          console.log(sectionlist);
          $('#editclass_id').html(classlist);
          $('#editsectionid').html(sectionlist);

          }  });
       $('#feecatEditModal').modal('show');
   });
  $('body').on('submit','#editfeecategory',function(e){
      e.preventDefault();
      $('#CLASS_ID_err').text('');
      $('#SECTION_ID_err').text('');
      $('#CATEGORY_err').text('');
      $('#SHIFT_err').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("updatefeecategory")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               console.log(data)

               for(i=0;i<data.length;i++){
                var type = data.SHIFT==1?'Morning':'Evening';
                $('#row' + +data[i].FEE_CAT_ID).replaceWith(`
                     <tr id="row`+data.FEE_CAT_ID+`">
                        <td class="mailbox-name">` + data[i].CATEGORY + `</td>
                        <td class="mailbox-name">` + type + `</td>

                        <td class="mailbox-date pull-right">
                     <button value="`+data[i].FEE_CAT_ID+`" class="btn btn-default btn-xs editbtn" > edit </button>
                     <button value="`+data[i].FEE_CAT_ID+`" class="btn btn-default btn-xs deletebtn"> delete </button>
                          </td>
                      </tr>`);
                      $("#editfeecategory").get(0).reset();
                      $('#feecatEditModal').modal('hide');
                      toastr.success('Updated Successfuyy','Success');
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
