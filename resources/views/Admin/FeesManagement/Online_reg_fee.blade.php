@extends('Admin.layout.master')
@section("page-css")
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
<link href="{{asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section("content")
<div class="row">
   <div class="col-md-12">
      <div class="card m-b-30 card-body">
          <div class="row">
                <div class="col-md-3">
                <div class="form-group">
                    <form action="" id="online-reg-fee" method="post">
                        @csrf
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
                </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="">{{Session::get('class')}} *<span class="gcolor"></span> </label>
                  <select class="form-control formselect required" placeholder="Select Class" name="CLASS_ID"
                    id="class_id">
                    <option value="0" disabled selected>Select
                    {{Session::get('class')}}*</option>
                    @foreach($classes as $class)
                    <option  value="{{ $class->Class_id }}">
                        {{ ucfirst($class->Class_name) }}</option>
                    @endforeach
                </select>
                <small id="CLASS_ID_error" class="form-text text-danger"></small>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for=""> Amount *<span class="gcolor"></span> </label>
                 <input type="text" name="REGFEE" class="form-control required" id="REGFEE" value="">
                <small id="REGFEE_error" class="form-text text-danger"></small>
              </div>
            </div>
    
            <div class="col-md-3">
              <div class="form-group">
                  <label for="">Search</label>
                  <div class="input-group">
                      <input type="submit" value="Apply Fee" class="btn btn-primary ">
                      </form>
                  </div>
                 
                 
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  <div class="row">
   <div class="col-md-12">
      <div class="card m-b-30 card-body">
      <div class="row">
                    <h3 style="margin-left:20px"> REG-FEE LOG</h3>
                </div>
            <div class="row">
            <div class="col-md-12">
            <table id="DataTables_Table_0" class="table table-striped table-bordered table-hover " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                      <tr>
                        <th scope="col">{{Session::get('session')}}</th>
                        <th scope="col">{{Session::get('class')}}</th>
                        <th scope="col">Amount</th>
                      </tr>
                    </thead>
                    <tbody id="displaydata">
                    @if(isset($datas))
                      @foreach($datas as $data)
                      <tr id="row{{$data->ONLINEREGID}}">
                      <td>{{$data->SB_NAME}}</td>
                      <td>{{$data->Class_name}}</td>
                      <td>{{$data->REGFEE}}</td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>  
</div>

@endsection
@section("customscript")
 <!-- Required datatable js -->
 <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
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
      $(document).ready(function(){
        $('#DataTables_Table_0').DataTable();
    $('#class_id').on('change', function () {
       
        SESSION_ID = $('#SESSION_ID').val();
        if(SESSION_ID == null){

                toastr.error('Please Select session first','Error');
                return false;
        }
                CLASS_ID = $(this).val();
                $.ajax({
                type: 'GET',
                url: 'search_reg_fee/',
                data :{SESSION_ID:SESSION_ID,CLASS_ID:CLASS_ID},
                success: function(data){
                console.log(data);
                if ($.trim(data) == '' ) {
                 
                  }
                  else
                  {
                    $('#REGFEE').val(data.REGFEE);
                  }
            },
        });
    });

   $('body').on('submit','#online-reg-fee',function(e){
   e.preventDefault();
   $('#CLASS_ID_error').text('');
   $('#SESSION_ID_error').text('');
   $('#REGFEE_error').text('');
   var fdata = new FormData(this);
    html="";
   $.ajax({
        url: '{{url("apply_reg_fee")}}',
            type:'POST',
            data :fdata,
            processData: false,
            contentType: false,
            success: function(data){
               //return false;
               if(data==true){
                toastr.success('Successfully Submitted', 'Notice');
                setTimeout(function(){location.reload();},1000);
                }
            else {
               toastr.warning('Error in Query', 'Notice');
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

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
   });
</script>

@endsection
