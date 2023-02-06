@extends('Admin.layout.master')
@section("page-css")
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
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Class *<span class="gcolor"></span> </label>
                  <select class="form-control formselect required" placeholder="Select Class"
                    id="class_id">
                    <option value="0"  selected>Select
                    {{Session::get('class')}}*</option>
                    @foreach($classes as $class)
                    <option  value="{{ $class->Class_id }}">
                        {{ ucfirst($class->Class_name) }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                   <label>{{Session::get('section')}}*</label>
                  <select class="form-control formselect required" placeholder="Select Section" id="sectionid">
                    <option value="0"  selected>Select
                  </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="">Search</label>
                  <div class="input-group">
                     <input type="text" class="form-control" placeholder="Search.." name="search2">
                      <div class="input-group-append">
                      <button type="button" class="btn btn-info btn-sm "><i class="fa fa-search"></i></button>
                      </div>
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
            <div class="col-md-12" id="displaydata">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- <div class="container mt-4">
        <div class="row">

            <div class="col-md-4">
                <h3>Category*<span class="gcolor"></span> </h3>
                <div class="form-s2">
                    <div>
                        <select class="form-control formselect required" placeholder="Select Class"
                            id="class_id">
                            <option value="0" disabled selected>Select
                                Class*</option>
                            @foreach($classes as $class)
                            <option  value="{{ $class->Class_id }}">
                                {{ ucfirst($class->Class_name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <h3>section*</h3>
                <select class="form-control formselect required" placeholder="Select Section" id="sectionid"
                    >
                </select>
            </div>
            <div class="col-md-4">
                <h3>Search*</h3>
                <div class="form-s2">
                <form class="example" action="/action_page.php" style="margin:auto;max-width:300px">
                  <input type="text" placeholder="Search.." name="search2">
                  <button type="submit"><i class="fa fa-search"></i></button>
                  </form>
                    <div>
                      
                    </div>
                </div>
            </div>
       </div>

       <div class="row" style="padding-top: 40px;">
            <div class="col-md-12" id="displaydata">
            </div>
            </div>

</div> -->

@endsection
@section('customscript')
<script>  
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
<script>
        $(document).ready(function () {
          $('#class_id').on('change', function () {
          let id = $(this).val();
          $('#sectionid').empty();
          $('#sectionid').append(`<option value="0" disabled selected>Processing...</option>`);
          $.ajax({
            type: 'GET',
            url: 'getsections/' + id,
            success: function (response) {
            var response = JSON.parse(response);
            //console.log(response);   
            $('#sectionid').empty();
            $('#sectionid').append(`<option value="0" disabled selected>Select Section*</option>`);
            response.forEach(element => {
                $('#sectionid').append(`<option value="${element['Section_id']}.${element['Class_id']}">${element['Section_name']}</option>`);
                });
            }
          });
        });
        $('#sectionid').on('change', function () {
                let id = $(this).val();
                let html = "";
                $.ajax({
                type: 'GET',
                dataType: "json",
                url: 'getmatchingdata/'+ id,
                success: function (data) {
                  if ($.trim(data) == '' ) {
                    html +='<p style="text-align:center;color:red;"> NO Result Match </p>';
                  }
                  else
                  {
                    html += ' <div class="table-responsive">';
                    html += '<table id="DataTables_Table_0" class="table table-bordered">';
                    html += '<thead>';
                    html += ' <tr>';
                    html += '   <th scope="col">Student ID</th>';
                    html += '    <th scope="col">Student Name</th>';
                    html += '   <th scope="col">FATHER NAME</th>';
                    html += '    <th scope="col">FATHER Contact</th>';
                    html += '    <th scope="col">PRESENT ADDRESS</th>';
                    html += '    <th scope="col">Student Picture</th>';
                    html += '     <th scope="col">Edit</th>';
                    html += '     <th scope="col">View Details</th>';
                    html += '   </tr>';
                    html += ' </thead>';
                    html += ' <tbody>';
                    for (i = 0; i < data.length; i++) {
                     let image = (!data[i].IMAGE == "") ? '{{asset("upload")}}/{{Session::get("CAMPUS_ID")}}/'+data[i].IMAGE : 'https://via.placeholder.com/200';
                      html += '<tr id="row'+data[i].STUDENT_ID+'">';
                      html += '  <td>'+ data[i].STUDENT_ID+' </td>';
                      html += '  <td>' + data[i].NAME+ '</td>';
                      html += '  <td>' + data[i].FATHER_NAME+ '</td>';
                      html += '  <td>' + data[i].FATHER_CONTACT+ '</td>';
                      html += '  <td>' + data[i].PRESENT_ADDRESS + '</td>';
                      html += '  <td><img src="'+image+'" style="width:50px;height:50px;" alt=""></td>';
                      html += '   <td>';
                      html += '     <a href="editstudent/'+ data[i].STUDENT_ID+'" class="btn btn-success editbtn">Edit</a>';
                      html += '   </td>';
                      html += '   <td> <a href="student/viewstudentdetails/'+ data[i].STUDENT_ID+'" class="btn btn-success viewbtn">Details</a></td>';
                      html += '</tr>';
                    }
                    html += '</tbody>';
                   html += '</table>';
                   html += '</div>';

                  }
                  $("#displaydata").empty();
                $('#displaydata').html(html);
                $('#DataTables_Table_0').DataTable();
                }
                
              });
            });
    });
  </script>
@endsection