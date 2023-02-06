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
                <div class="col-md-2">
                <div class="form-group">
                    <form action="{{route('ResultPrint')}}"  method="post">
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
                        @error('SESSION_ID')
                        <p style="color:red;"> <strong>{{ $message }}</strong> </p> 
                          @enderror
                </div>
                </div>
            <div class="col-md-2">
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
                @error('CLASS_ID')
                <p style="color:red;"> <strong>{{ $message }}</strong> </p> 
                @enderror
             
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                   <label>{{Session::get('section')}}*</label>
                  <select class="form-control formselect required" placeholder="Select Section" name="SECTION_ID" id="sectionid">
                    <option value="0" disabled selected>Select {{Session::get('section')}}
                  </select>
                  @error('SECTION_ID')
                  <p style="color:red;"> <strong>{{ $message }}</strong> </p> 
                @enderror
            
              </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Exam*</label>
                <select class="form-control formselect required" placeholder="Select Exam" name="EXAM_ID" id="EXAM_ID">
                <option value="0" disabled selected>Select
                              Exam*</option>
               
                @foreach($gexam as $exam)
                    <option  value="{{ $exam->EXAM_ID}}">
                        {{ ucfirst($exam->EXAM_NAME) }}</option>
                @endforeach
                </select>
                @error('EXAM_ID')
                <p style="color:red;"> <strong>{{ $message }}</strong> </p> 
                @enderror
           
            </div>
                </div>
            <div class="col-md-2">
              <div class="form-group">
                  <label for="">Search</label>
                  <div class="input-group">
                      <input type="submit" value="PRINT RESULT" class="btn btn-primary ">
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
            <div class="col-md-12" id="displaydata">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

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
                $('#sectionid').append(`<option value="${element['Section_id']}">${element['Section_name']}</option>`);
                });
            }
          });
        });
    });
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

    $('body').on('change','#EXAM_ID',function(){
        var exam_id = $(this).val();
        var SESSION_ID = $('#SESSION_ID').val();
        var CLASS_ID = $('#class_id').val();
        var SECTION_ID = $('#sectionid').val();
        $.ajax({
        url: '{{url("getsubjectadmin")}}',
            type:'POST',
            data :{EXAM_ID:exam_id,SESSION_ID:SESSION_ID,CLASS_ID:CLASS_ID,SECTION_ID:SECTION_ID},
            // processData: false,
            // contentType: false,
            success: function(data){
                console.log(data);                    
            $('#SUBJECT_ID').empty();
            $('#SUBJECT_ID').append(`<option value="0" disabled selected>Select Subject*</option>`);
            data.forEach(element => {
                $('#SUBJECT_ID').append(`<option value="${element['SUBJECT_ID']}">${element['SUBJECT_NAME']}</option>`);
                });
            },
        });
    });
  </script>
@endsection