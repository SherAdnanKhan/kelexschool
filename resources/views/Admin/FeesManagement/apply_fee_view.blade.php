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
            <form id="applyfeeform" accept-charset="utf-8">
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
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="due_date">Due date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Select Month</label>
                         @foreach($months as $key => $value)
                        <div class="input-group mb-3">
                            @foreach($value as $k=>$v)
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <input type="checkbox" name ="month" aria-label="Checkbox for following text input" value="{{$v->NUMBER}}" class="month">
                                </div>
                            </div>
                        <input type="text" class="form-control col-3" aria-label="Text input with checkbox" value="{{$v->MONTH}}" disabled>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm" >
                        <label id="FEE_LABEL"></label>
                        <div class="input-group mb-3 FEE_CATEGORY" id="">



                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <button type="submit" class="btn save-btn btn-primary btn-rounded btn-block waves-effect waves-light apply-fee-btn">Apply Fee
                        </button>

                    </div>

                    </div>
                </div>
                 @csrf

            </form>
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
   });
</script>
<Script>
    $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$('body').on('change','#sectionid',function(){
    var session_id = $('#session_id').val();
    var class_id = $('#class_id').val();
    var section_id = $(this).val();
    try {
        var html = "";
        $.ajax({
            url: '{{url("get-section-fee-category")}}/'+session_id+'/'+class_id+'/'+section_id,
            type:'GET',

            success: function(res){
                var data = res.FEE_AMOUNT;
                var cat = res.category;
                var check = res.check_record;
                var inc = 0;
                $.each(data,function(k,v) {
                   $.each(v,function(key,val){
                        html += '<div class="input-group-prepend" id="month_div_'+val+'"><div class="hidden-div"></div>';
                        html +=      '<div class="input-group-text">';
                        html +=        '<input type="checkbox" name ="fee_category[]" value="'+key+'" aria-label="Checkbox for following text input" class="fee_category_id">';
                        html +=       '</div>';
                        html +=  '</div>';
                        html += '<input type="text" class="form-control col-3" aria-label="Text input with checkbox" value="'+cat[inc]+"  =>  "+val+'" disabled>';
                        inc++;
                   });
                });

                $('#FEE_LABEL').text('Select Fee Category To be Applied.');
                $('.FEE_CATEGORY').html(html);
                console.log(check);
                if(check.length !== 0)
                {
                    if(check.months.length > 0 )
                    {
                        $('.hidden-div').html('<input type="hidden" name="fee_id" value="'+check.fee_id+'">');
                        $.each(check.months,function(key,val){
                            $('input[value="'+val+'"]').prop('disabled',true);
                        });
                    }
                }

            }
        });
    } catch (error) {
        alert(error);
    }
});




$('body').on('submit','#applyfeeform',function(e){
      e.preventDefault();
      var session_id = $('#session_id').val();
      var class_id = $('#class_id').val();
      var section_id = $('#sectionid').val();
      var due_date = $('#due_date').val();
      var month_arr = new Array();
      var cat_arr = new Array();

     $('.month').each(function(){
         if(this.checked){
          month_arr.push($(this).val());
         }
      });
      $('.fee_category_id').each(function(){
          if(this.checked){
             cat_arr.push($(this).val());
          }

      });
      if(cat_arr.length < 1){
          toastr.error('Please Select at least single Fee Category to process','ERROR');
          return false;
      }
     if(month_arr.length < 1){
          toastr.error('Please Select at least single Fee Category to process','ERROR');
          return false;
      }
    if(due_date == "" ){
          toastr.error('Please Select Due Date','ERROR');
          return false;
      }
      $('.save-btn').prop('disabled',true).html('<div class="spinner-border spinner-border-sm text-light" role="status"><span class="sr-only">Applying Fee...</span></div>');
    try {
        // $('.apply-fee-btn').prop();
        var data = {
            session_id:session_id,
            section_id:section_id,
            class_id:class_id,
            months:month_arr,
            category:cat_arr,
            due_date : due_date,
            "_token": "{{ csrf_token() }}"};
            console.log(data);
        $.ajax({
            url: '{{route("apply-fee-on-sections")}}',
                type:'POST',
                data: data,
                // processData: false,
                // contentType: false,
                success: function(data){
                    if(data.type == 0){
                        toastr.error(data.response,'Error');
                    }
                    if(data.type == 1){
                        toastr.success(data.response,'Success');
                        setTimeout(function() {
                            $('#applyfeeform')[0].reset();
                        }, 100);
                    }
                }
        });
         $('.save-btn').prop('disabled',false).html('Apply Fee');
    } catch (error) {
        alert(error);
    }
    //   var fdata = new FormData(this);
    //   $.ajax({
    //     url: '{{url("addfeecategory")}}',
    //         type:'POST',
    //         data: fdata,
    //         processData: false,
    //         contentType: false,
    //         success: function(data){
    //           console.log(data)
    //           var type = data.SHIFT==1?'Morning':'Evening';
    //             $('#displaydata').append(`
    //                  <tr id="row`+data.FEE_CAT_ID+`">
    //                     <td class="mailbox-name">` + data.CATEGORY + `</td>
    //                     <td class="mailbox-name">` + data.CLASS_ID + `</td>
    //                     <td class="mailbox-name">` + data.SECTION_ID + `</td>
    //                     <td class="mailbox-name">` + type + `</td>

    //                     <td class="mailbox-date pull-right">
    //                  <button value="`+data.FEE_CAT_ID+`" class="btn btn-primary btn-xs editbtn" > Edit </button>
    //                       </td>
    //                   </tr>`)
    //                   $("#addfeecategory").get(0).reset();
    //                  location.reload();
    //                  //  $('#DataTables_Table_0').DataTable().destroy().draw();
    //           },
    //           error: function(error){
    //             console.log(error);
    //             var response = $.parseJSON(error.responseText);
    //                 $.each(response.errors, function (key, val) {
    //                     $("#" + key + "_error").text(val[0]);
    //                 });
    //           }
    //   });
    });

</script>


@endsection
