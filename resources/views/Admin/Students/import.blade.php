@extends('Admin.layout.master')
@section("page-css")
    <link rel="stylesheet" type="text/css" href="{{ url('assets/dist/css/dropify.min.css') }}">
@endsection
@section("content")
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="card m-b-20">
        <div class="row">
        <div class="form-group">
                                <div class="col-md-6" style=" display: inline;">
                                        <label>
                                         Your CSV data should be in the format below.<br>
                                         1. The first line of your CSV file should be the column headers as in the Sample example.<br>
                                         2. Make sure that your file is UTF-8 to avoid unnecessary encoding problems. <br>
                                        3. If the column you are trying to import is date make sure that is formatted in format Y-m-d (2018-06-06).<br>
                                        4. For student "Gender" use Male, Female value.<br>
                                        5. For student "Blood Group" use O+, A+, B+, AB+, O-, A-, B-, AB- value.<br>
                                        6. For "Shift" use 1 for Yes, 2 for No value.<br>
                                        7. For "If Guardian Is" user father,mother,other value.<br>
                                        8. Category name comes from other table so for "category", enter Category Id (Category Id can be found on category page ).<br>
                                        9. Student house comes from other table so for "student house", enter Student House Id (Student House Id can be found on student house page ).<br>
                                                                                Check The Csv Format here!!  
                                        </label>
                                        <a href="/download" class="btn btn-info pull-right"><i class="icon-download-alt"> </i> Download Sample </a>
                                </div>
                            </div>
        </div>
        <div class="row">
                                 <div class="col-md-4">
        <form class="form-horizontal" id="csvform" method="POST" action="{{ route('import_process') }}" enctype="multipart/form-data">

                                    <div class="form-group">
                                        
                                       <label for="">{{Session::get('session')}}</label>
                                          <small class="req"> *</small>
                                          <select name="SESSION_ID" class="form-control formselect required" placeholder="Select Section" id="SESSION_ID" >
                                            <option value="">Select</option>
                                            @foreach($sessions as $session)
                                            <option value="{{$session->SB_ID}}">{{$session->SB_NAME}}</option>
                                                @endforeach
                                            </select>
                                            <small id="SESSION_ID_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">{{Session::get('class')}}</label>
                                        <small class="req"> *</small>
                                        <select name="CLASS_ID" class="form-control formselect required" placeholder="Select Class"
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
                                 <div class="col-md-4">
                                     <div class="form-group">
                                       <label for="">{{Session::get('section')}}</label>
                                          <small class="req"> *</small>
                                          <select name="SECTION_ID" class="form-control formselect required" placeholder="Select Section" id="sectionid" >
                                       </select>
                                       <small id="SECTION_ID_error" class="form-text text-danger"></small>
                                    </div>
                                 </div>
</div>
<div class="row">
            <div class="col-md-8 ">
                <div class="panel panel-default">
                    <div class="panel-body">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                <label for="csv_file" class="col-md-4 control-label">CSV file to import</label>

                                <div class="col-md-6">
                                    <input id="csv_file" type="file" class="form-control" name="csv_file" required>
                                    <small id="csv_file_error" class="form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn submitbtn btn-primary">
                                        Submit CSV
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customscript')
<script>
 $(document).ready(function(){
    $('.dropify').dropify();
    $('#class_id').on('change', function () {
                let id = $(this).val();
                class_id = id;
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

$('body').on('submit','#csvform',function(e){
    $(".submitbtn").prop('disabled', true); 
    e.preventDefault();
      $('#csv_file_error').text('');
      $('#SESSION_ID_error').text('');
      $('#CLASS_ID_error').text('');
      $('#SECTION_ID_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("import_process")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
                // return false;
                $(".submitbtn").prop('disabled', false);
                if(data.status)
                {
                toastr.success('Student Data Uploaded Successfully  '+data.totalstudents,'Notice')
                setTimeout(function(){ window.location=data.url;},1000);       
                }
                else
                {
                    toastr.error(' Csv Format Is Wrong Please Check Format and Try Again','Notice');
                }
               console.log(data) 
              },
              error: function(error){
                $(".submitbtn").prop('disabled', false); 
               console.log(error);
               var response = $.parseJSON(error.responseText);
                    $.each(response.errors, function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
    }



      });
    });
</script>
@endsection
