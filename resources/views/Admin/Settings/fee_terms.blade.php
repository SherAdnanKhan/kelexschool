@extends('Admin.layout.master')
@section("page-css")
  <!-- DataTables -->
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
   <div class="col-md-9 col-sm-12 col-lg-9">

      <div class="card m-b-30 card-body ">
            <h3 class="card-title font-16 mt-0">FEE SLIP TERMS AND CONDETION</h3>
            {{-- <form action="{{ route('fee-terms')}}" id="fee_terms" name="fee_terms" method="post" accept-charset="utf-8"> --}}
                @php
                    $terms = (isset($fee_terms->FEE_TERMS_CONDETIONS)) ? $fee_terms->FEE_TERMS_CONDETIONS : "";
                    $setting_id = (isset($fee_terms)) ? $fee_terms->SETTING_ID : "";
                @endphp
                <div class="form-group">
                      <textarea name="fee_terms" class="form-control" name="fee_terms" id="fee_terms" cols="30" rows="10" placeholder="Fee Terms & Condetions for printing on Student Fee Voucher's... ">
                          {!!$terms!!}
                      </textarea>
                 </div>
                 <input type="hidden" id="fee_terms_setting_id" name="fee_terms_setting_id" value="{{$setting_id}}">
                 <div class="form-group">
                     <button type="submit" class="btn btn-primary btn-rounded waves-effect waves-light save-btn">Save</button>

                 </div>
            {{-- @csrf
            </form> --}}
      </div>
   </div>

</div>
 @endsection

 @section("customscript")
 <!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
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

$(document).ready(function () {
    $('#fee_terms').summernote({
         height: 300,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: true
    });
});


///////////////////////////////////////////////
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
$('body').on('click','.save-btn',function () {
   var terms = $('#fee_terms').summernote('code');
   var setting_id = $('#fee_terms_setting_id').val();
   var fdata ={terms:terms,setting_id:setting_id};
        try {
         $.ajax({
            url: '{{route("fee-terms")}}',
            type:'POST',
            data: fdata,
            // processData: false,
            // contentType: false,
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




  </script>


@endsection
