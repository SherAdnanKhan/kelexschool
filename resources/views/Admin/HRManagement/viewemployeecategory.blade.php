@extends('Admin.layout.master')
@section("page-css")
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
<link href="{{asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section("content")
<div class="page-content-wrapper">
                        <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
    
                                            <h4 class="mt-0 header-title">Employee Details</h4>
                                    <div class="table-responsive">
                                      <table id="DataTables_Table_0" class="table table-striped table-bordered table-hover " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                             <thead>
                                                <tr>
                                                  <th scope="col">Staff ID</th>
                                                  <th scope="col">Employee NO</th>
                                                  <th scope="col">Name</th>
                                                  <th scope="col">Designation</th>
                                                  <th scope="col">QUALIFICATION</th>
                                                  <th scope="col">Type</th>
                                                  <th scope="col">Image</th>
                                                  <th scope="col">Action</th>
                                                  <th scope="col">Details</th>
                                                </tr>
                                              </thead>
                                              <tbody id="displaydata">
                                                  
                                                @foreach ($employees as $employee)
                                                <tr id="row{{$employee->EMP_ID}}">
                                                  <td>{{$employee->EMP_ID}}</td>
                                                  <td>{{$employee->EMP_NO}}</td>
                                                  <td>{{$employee->EMP_NAME}}</td>
                                                  <td>{{$employee->DESIGNATION_ID}}</td>
                                                  <td>{{$employee->QUALIFICATION}}</td>
                                                  <td><?= $employee->EMP_TYPE==1?'Teaching':'Non Teaching'?></td>
                      
                                                  <td><img src="{{asset('upload/employee')}}{{Session::get('CAMPUS_ID')}}/{{$employee['EMP_IMAGE']}}" onerror="this.src='https://via.placeholder.com/200'" alt="" style="width: 50px;height:50px;"></td>
                                                  <td>
                                                      <a href="editemployee/{{$employee->EMP_ID}}" style="margin-right:10px;" class="btn btn-success editbtn"> Edit </a>
                                                  </td>
                                                  <td>
                                                      <a href="get-employee-details/{{$employee->EMP_ID}}" class="btn btn-danger editbtn"> Details </a>
                                                  </td>
                                                </tr>
                                                @endforeach
                                              </tbody>
                                            </table>
                                            </div>
                                            <a href="{{route('employee')}}" class="btn btn-primary">Add New Employee</a>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                      </div>
@endsection
@section("customscript")
<script>  
       $(document).ready( function () {
       $('#DataTables_Table_0').DataTable();
        });

</script>
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

@endsection