@extends('Admin.layout.master')
@section("page-css")
  <!-- DataTables -->
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
   <div class="col-sm-11">
      <div class="card m-b-30 card-body">
            <h3 class="card-title font-16 mt-0">Apply Students Fee </h3>

                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">{{Session::get('session')}}</label>
                                <small class="req"> *</small>
                                <select name="session_id" class="form-control formselect required" placeholder="Select Session"
                                    id="session_id" required>
                                    <option value="" disabled selected>Select
                                    {{Session::get('session')}}*</option>
                                    @foreach($sessions as $row)
                                    <option  value="{{ $row->SB_ID }}">
                                        {{ ucfirst($row->SB_NAME) }}</option>
                                    @endforeach
                            </select>
                            <small id="CLASS_ID_error" class="form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">{{Session::get('class')}}</label>
                                <small class="req"> *</small>
                                <select name="CLASS_ID" class="form-control formselect required" placeholder="Select Class"
                                    id="class_id" required>
                                    <option value="" disabled selected>Select
                                    {{Session::get('class')}}*</option>
                                    @foreach($classes as $class)
                                    <option  value="{{ $class->Class_id }}">
                                        {{ ucfirst($class->Class_name) }}</option>
                                    @endforeach
                            </select>
                            <small id="CLASS_ID_error" class="form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">{{Session::get('section')}}</label>
                                <small class="req"> *</small>

                                <select required name="SECTION_ID" class="form-control formselect required" placeholder="Select Section" id="sectionid" >
                                    <option value="" disabled>Select {{Session::get('section')}} </option>
                                </select>
                            <small id="SECTION_ID_error" class="form-text text-danger"></small>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-6" >
                        <label id="FEE_LABEL"></label>
                        <div class="input-group mb-4 FEE_CATEGORY" id="">

                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-success active">
                                    <input type="radio" name="options" id="print-type" value="1" checked> Single Student Copy
                                </label>
                                <label class="btn btn-info">
                                    <input type="radio" name="options" id="print-type" value="2"> Double Student + School Copy
                                </label>
                                <label class="btn btn-warning">
                                    <input type="radio" name="options" id="print-type" value="3"> Triple Student + School + Bank Copy
                                </label>
                                </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <button type="button" class="btn print-btn btn-primary btn-rounded btn-block waves-effect waves-light">PRINT FEE VOUCHERS</button>
                    </div>

                    </div>
                </div>
                 @csrf


      </div>
   </div>
</div>
@if (session('msg'))
    <div class="row">
        <div class="col-sm-11">
            <div class="card m-b-30 card-body">
                <div class="alert alert-danger">
                    {{ session('msg') }}
                </div>
            </div>
        </div>
    </div>
@endif





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
                $('#sectionid').append(`<option value="">Select Section*</option>`);
                response.forEach(element => {
                    $('#sectionid').append(`<option value="${element['Section_id']}">${element['Section_name']}</option>`);
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
$('body').on('click','.print-btn',function(){
    var session_id = $('#session_id').val();
    var class_id = $('#class_id').val();
    var section_id = $('#sectionid').val();
    var type = $('#print-type:checked').val();
    if((session_id == "") || (session_id == null))
    {
        toastr.error('Select Session..','Error');
        return false;
    }
    if((class_id == "") || (class_id == null))
    {
        toastr.error('Select class..','Error');
        return false;
    }
    if((section_id == "") || (section_id == null))
    {
        toastr.error('Select Section..','Error');
        return false;
    }
    window.open('{{url("get-section-fee")}}/'+session_id+'/'+class_id+'/'+section_id+'/'+type, '_blank');
});
// $('body').on('change','#sectionid',function(){
//     var session_id = $('#session_id').val();
//     var class_id = $('#class_id').val();
//     var section_id = $(this).val();
//     try {
//         var html = "";
//         $.ajax({
//             url: '{{url("get-section-fee")}}/'+session_id+'/'+class_id+'/'+section_id,
//             type:'GET',

//             success: function(res){
//                 // var data = res.FEE_AMOUNT;
//                 // var cat = res.category;
//                 // var check = res.check_record;
//                 // var inc = 0;
//                 // $.each(data,function(k,v) {
//                 //    $.each(v,function(key,val){
//                 //         html += '<div class="input-group-prepend">';
//                 //         html +=      '<div class="input-group-text">';
//                 //         html +=        '<input type="checkbox" name ="fee_category[]" value="'+key+'" aria-label="Checkbox for following text input" class="fee_category_id">';
//                 //         html +=       '</div>';
//                 //         html +=  '</div>';
//                 //         html += '<input type="text" class="form-control col-3" aria-label="Text input with checkbox" value="'+cat[inc]+"  =>  "+val+'" disabled>';
//                 //         inc++;
//                 //    });
//                 // });

//                 // $('#FEE_LABEL').text('Select Fee Category To be Applied.');
//                 // $('.FEE_CATEGORY').html(html);
//             }
//         });
//     } catch (error) {
//         alert(error);
//     }
// });




</script>


@endsection
