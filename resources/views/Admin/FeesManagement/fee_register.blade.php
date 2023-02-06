@extends('Admin.layout.master')
@section("page-css")
  <!-- DataTables -->
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card m-b-30 card-body">
                    <h3 class="card-title font-16 mt-0">Fee Register</h3>

                <table class="table table-hover table-responsive table-sm table-responsive " id="table">
                    <thead class="thead-light" >
                    <tr>
                        <th>STUDENT</th>
                        <th>FATHER</th>
                        <th>{{Session::get('class')}}</th>
                        <th>AMOUNT</th>
                        <th>BALANCE/ADAVNCE</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($record as $row)
                        <tr>
                            <th>{{$row->NAME}}</th>
                            <th>{{$row->FATHER_NAME}}</th>
                        <th>{{$row->Class_name}} <span class="badge badge-primary">{{$row->Section_name}}</span></th>
                            <th>{{number_format($row->FEE_AMOUNT,2)}}</th>
                            <th>
                                <button type="button" class="btn btn-primary btn-sm">
                                    {{number_format(abs($row->AMOUNT),2)}}

                                @if($row->TYPE == 1)
                                    <span class="badge badge-pill badge-danger">Balance</span>
                                @else
                                     <span class="badge badge-pill badge-success">Advance</span>
                                @endif

                                </button>
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

      {{-- <div class="card m-b-30 card-body">
            <h3 class="card-title font-16 mt-0">Family Accounts</h3>
            <form action="{{ route('addfeecategory')}}" id="search-fee" name="sectionform" method="post" accept-charset="utf-8">
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm 12">
                        <div class="form-group">
                            <label for="">{{Session::get('session')}}</label>
                                <small class="req"> *</small>
                                <select name="SESSION_ID" class="form-control formselect required" placeholder="Select Class"
                                    id="session_id">
                                    <option value=""  selected>Select
                                    {{Session::get('session')}} *</option>
                                    @foreach($sessions as $row)
                                    <option  value="{{ $row->SB_ID }}">
                                        {{ ucfirst($row->SB_NAME) }}</option>
                                    @endforeach
                            </select>
                            <small id="session_id" class="form-text text-danger"></small>
                        </div>
                    </div>
                     @csrf
                    </div>
                </div>
            </form>
      </div> --}}
       {{-- <div class="card m-b-30 card-body fee-div" style="display: none">
            <h3 class="card-title font-16 mt-0">Details</h3>
            <form id="collect-fee" name="collectfee" method="post" accept-charset="utf-8">

                <div class="row">
                    <div class="col-12">
                        <table class="table table-hover fee-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>FAMILY NO#</th>
                                    <th>FATHER</th>
                                    <th>CHILDRENS</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <button class="btn btn-primary btn-save">SAVE RECORD</button>
                    </div>
                </div>
            </form>
      </div> --}}

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
      $('#table').DataTable({
          ordering : false
      });
        } );
     </script>
{{-- <script>
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
                $('#sectionid').append(`<option value="0"  selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'getsection/' + id,
                success: function (response) {
               //  var response = JSON.parse(response);
                //console.log(response);
                $('#sectionid').empty();
                $('#sectionid').append(`<option value=""  selected>Select Section*</option>`);
                response.forEach(element => {
                    $('#sectionid').append(`<option value="${element['Section_id']}">${element['Section_name']}</option>`);
                    });
                }
            });
        });
        $('#editclass_id').on('change', function () {
                let id = $(this).val();
                $('#editsectionid').empty();
                $('#editsectionid').append(`<option value="" disabled selected>Processing...</option>`);
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
</script> --}}
{{-- <Script>
    $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$('body').on('change','#session_id',function(e){
      e.preventDefault();
      var session_id = $(this).val();
    //   alert("Session => "+session_id+"Class=> "+class_id+"Section =>"+section_id);
      if(session_id == ""){
          toastr.error('Please select Session first','Error');
          return false;
      }
      $.ajax({
        url: 'get-family-accounts/'+session_id,
            type:'GET',
            // processData: false,
            // contentType: false,
            success: function(data){
                var html = '';
                $('.fee-div').fadeIn('fast');
                if(data.length == 0){
                    $('.fee-div').html('<div class="alert alert-primary">No record Found..</div>');
                    return false;
                }

                var s= 1;
                $.each(data,function(x,y){
                    // console.log(y.NAME);
                    // html += '<input type="hidden" name="student_id[]" value="'+y.STUDENT_ID+'">';
                    // html += '<input type="hidden" name="fee_id" value="'+y.FEE_ID+'">';
                    // html += '<input type="hidden" value="'+parseInt(y.FEE_AMOUNT).toFixed(0)+'" name="amount[]" class="form-control col-6 paidAmount">';
                    html += "<tr>";
                    html += "<td>"+s+"</td>";
                    html +="<td>"+y.FATHER_CNIC+"</td>";
                    html +="<td>"+y.FATHER_NAME+"</td>";
                    html += "<td>";
                        $.each(y.data,function(k,v) {
                            html += v.NAME+'  <span class="badge badge-primary"> '+v.Class_name+' ('+v.Section_name+')</span><br>';
                        });
                    html += "</td>";
                    // html +='<td><input type="number" value="0" name="paidAmount[]" class="form-control col-6 paidAmount" data-id="'+s+'"></td>';
                    // html += '<td><input type="number" name="remainingAmount[]" class="remainingAmount form-control col-6" id="'+s+'" value="0" disabled></d>';
                    html +='</tr>';
                    s++;
                });
                html += '@csrf';
                $('.fee-table').find('tbody').html(html);
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
    $('body').on('keyup keypress blur change','.paidAmount',function(){
        var ele = $(this).data('id');
        var amount = $(this).val();
        var total_amount = parseInt($('.totalAmount_'+ele).text());
        var remaining = parseInt(total_amount-amount);
        $("#"+ele).val(remaining);
    });

    $('body').on('submit','#collect-fee',function (e) {
        e.preventDefault();
        var session_id = $('#session_id').val();
        var class_id = $('#class_id').val();
        var section_id = $('#sectionid').val();
        var fdata = new FormData(this);
        fdata.append('session_id',session_id);
        fdata.append('class_id',class_id);
        fdata.append('section_id',section_id);
        $('.save-btn').prop('disabled',true);
        $.ajax({
            url: '{{route("fee-collection")}}',
                type:'POST',
                processData: false,
                contentType: false,
                data:fdata,
                success: function(data){
                  if(data.type == 1)
                  {
                       $('.fee-div').fadeOut('slow');
                      toastr.success(data.response,'Success!');
                  }else{
                      alert(data);
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
        $('.save-btn').prop('disabled',false);
    });

</script> --}}


@endsection
