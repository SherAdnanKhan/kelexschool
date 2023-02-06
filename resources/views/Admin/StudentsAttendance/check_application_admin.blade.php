@extends('Admin.layout.master')
@section("page-css")
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
<link href="{{asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content')

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                    <h1>Student Attendance details</h1>
                    
           {{--Table Attdence today display--}}
                   
                <div class="table-responsive">
                <small id="APPLICATION_STATUS_error" class="form-text text-danger"></small>
                <small id="APPROVED_AT_error" class="form-text text-danger"></small>
                <table id="DataTables_Table_1" class="table table-striped table-bordered table-hover " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                   <thead>
                      <tr>
                        <th scope="col">Application Type</th>
                        <th scope="col">From date</th>
                        <th scope="col">TO Date</th>
                        <th scope="col">Application Status</th>
                      </tr>
                    </thead>
                    <tbody id="displaydata">

                    @if(isset($applications) && count($applications)>0)
                    @foreach($applications as $application)

                      <tr id="row{{$application->STD_APPLICATION_ID}}">
                        <td><?= $application->APPLICATION_TYPE=='SL'?'Sick Leave':'Leave'?></td>
                        <td>{{$application->START_DATE}}</td>
                        <td>{{$application->END_DATE}}</td>
                        <td>
                      <button class="btn btn-danger btnapp" studentid="{{$application->STUDENT_ID}}" approveid="{{$application->STD_APPLICATION_ID}}" value="1"> approve </button>
                      &nbsp
                      <button class="btn btn-primary btnrej" studentid="{{$application->STUDENT_ID}}" rejectid="{{$application->STD_APPLICATION_ID}}" value="2"> reject </button> 
                        </td>
                      </tr>
                      @endforeach
                      @else
                      <h5 style="color:green"> All Application Processed</h5>
                      @endif
                    </tbody>
                  </table>
                </div>
            </div>
                <div class="row">
                    <h3> Attendance Log</h3>
                </div>
                    
           {{--Table Attendance Log display--}}         
           
                </div>
                <div class="table-responsive">
                <table id="DataTables_Table_0" class="table table-striped table-bordered table-hover " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                   <thead>
                      <tr>
                        <th scope="col">Application Type</th>
                        <th scope="col">From date</th>
                        <th scope="col">TO Date</th>
                        <th scope="col">Application Status</th>
                        <th scope="col">Response at</th>
                      </tr>
                    </thead>
                    <tbody id="displaydata">
                        @if(isset($todayapplog))
                      @foreach($todayapplog as $stdapplication)
                      <tr id="row{{$stdapplication->STD_APPLICATION_ID}}">
                        <td><?= $stdapplication->APPLICATION_TYPE=='SL'?'Sick Leave':'Leave'?></td>
                        <td>{{$stdapplication->START_DATE}}</td>
                        <td>{{$stdapplication->END_DATE}}</td>
                        <td>
                        <?php 
                        if($stdapplication->APPLICATION_STATUS=="1")
                        {
                          echo 'Approved';
                        }
                        else if($stdapplication->APPLICATION_STATUS=="2")
                        {
                          echo 'Rejected';
                        }
                        else
                        {
                          echo 'Pending';
                        }
                        ?>
                        </td>
                        <td><?= $stdapplication->APPROVED_AT==null?'Pending':$stdapplication->APPROVED_AT?></td>
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
@endsection
@section('customscript')
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
        <script src="{{asset('admin_assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
<script>
  $(document).ready( function () {
      $('#DataTables_Table_0').DataTable();
      $('#DataTables_Table_1').DataTable();
        } );
$('body').on('click', '.btnapp',function () {
        var APPLICATION_STATUS = $(this).val();
        var STD_APPLICATION_ID  = $(this).attr('approveid');
        var studentid  = $(this).attr('studentid');
        $.ajax({
            url: '{{url("actionApplicationAdmin")}}',
            type: "GET",
            data: {
               APPLICATION_STATUS:APPLICATION_STATUS,
               STD_APPLICATION_ID:STD_APPLICATION_ID,
               studentid:studentid
            }, 
            dataType:"json",
            success: function(data){
              if(data){
                toastr.success('Action Performed Successfully','Notice')
                setTimeout(function(){location.reload();},1000);
              }
              else
              {
                toastr.warning('Already Action taken, Please Refresh Page','Notice')
              }
            }
        });
   });

   $('body').on('click', '.btnrej',function () {
        var APPLICATION_STATUS = $(this).val();
        var STD_APPLICATION_ID =$(this).attr('rejectid');
        var studentid  = $(this).attr('studentid');
        $.ajax({
            url: '{{url("actionApplicationAdmin")}}',
            type: "GET",
            data: {
               APPLICATION_STATUS:APPLICATION_STATUS,
               STD_APPLICATION_ID:STD_APPLICATION_ID,
               studentid:studentid
            }, 
            dataType:"json",
            success: function(data){
              if(data){
                toastr.success('Action Performed Successfully','Notice')
                setTimeout(function(){location.reload();},1000);
              }
              else
              {
                toastr.warning('Already Action taken, Please Refresh Page','Notice')
              }
            }
        });

   });
</script>
@endsection
