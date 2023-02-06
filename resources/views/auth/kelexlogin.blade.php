@extends('layouts.app')

@section('content')
<div class="wrapper-page">

<div class="card">
    <div class="card-body">

        {{-- <h3 class="text-center m-0">
            <a href="{{ route('login') }}" class="logo logo-admin"><img src="assets/images/collabs_logo.png" height="30" alt="logo" style=" width: 24%; height: 24%;"></a>
        </h3> --}}

        <div class="p-3">
            <h4 class="text-muted font-18 m-b-5 text-center">Welcome Back !</h4>
            <p class="text-muted text-center">Sign in to continue.</p>
      <ul class="nav nav-pills nav-justified" role="tablist">
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link active border border-danger"  data-toggle="tab" href="#activity" role="tab">Admin</a>
                                                </li>
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link border border-danger " style="margin-left: 10px;"  data-toggle="tab" href="#fee" role="tab">Teacher</a>
                                                </li>
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link border border-danger" style="margin-left: 10px;"  data-toggle="tab" href="#documents" role="tab">Student</a>
                                                </li>
                                          </ul>
            <div class="tab-content" style="padding:20px;">
               <div class="tab-pane active" id="activity">
                  <div class="tshadow mb25 bozero">
                        <form class="form-horizontal m-t-30" id="Adminloginform" method='Post'action="{{ route('login') }}">

                        <div class="form-group">
                        <small id="Adminlogin_error" class="form-text text-danger"></small>
                        <label for="username">Admin Username</label>
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Enter username">
                        <small id="username_error" class="form-text text-danger"></small>
                        </div>
                        @csrf

                        <div class="form-group">
                        <label for="userpassword">Admin Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter password">
                        <small id="password_error" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group row m-t-20">
                        <div class="col-6">
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customControlInline" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customControlInline">Remember me</label>
                        </div>
                        </div>
                        <div class="col-6 text-right">
                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">
                            Login
                        </button>

                        </div>
                        </div>

                        <div class="form-group m-t-10 mb-0 row">
                        <div class="col-12 m-t-20">
                        <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                        </div>
                        </div>
                        </form>
                  </div>
               </div>
               <div class="tab-pane" id="fee">
               <form class="form-horizontal m-t-30" id="Teacherloginform"  method='Post'action="{{ route('loginteacher') }}">

                        <div class="form-group">
                        <small id="teacherlogin_error" class="form-text text-danger"></small>
                        <label for="username">Teacher Employee No</label>
                        <input type="text" class="form-control " name="EMP_NO" value="{{ old('EMP_NO') }}" placeholder="Enter EMPLOYEE User Name">
                        <small id="EMP_NO_error" class="form-text text-danger"></small>
                        </div>
                        @csrf

                        <div class="form-group">
                        <label for="userpassword">Teacher Password</label>
                        <input type="password" class="form-control" name="PASSWORD" placeholder="Enter PASSWORD">
                        <small id="PASSWORD_error" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group row m-t-20">
                        <div class="col-6">
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customControlInlineT" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customControlInlineT">Remember me</label>

                        </div>
                        </div>
                        <div class="col-6 text-right">

                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                        </div>
                        </div>

                        <div class="form-group m-t-10 mb-0 row">
                        <div class="col-12 m-t-20">
                        <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                        </div>
                        </div>
                        </form>
               </div>
               <div class="tab-pane" id="documents">
               <form class="form-horizontal m-t-30" id="Studentloginform" method='Post'action="{{ route('loginstudent') }}">

                    <div class="form-group">
                    <small id="studentlogin_error" class="form-text text-danger"></small>
                    <label for="username">Student USER ID</label>
                    <input type="text" class="form-control " name="REG_NO" value="{{ old('REG_NO') }}" placeholder="Enter User ID">
                    <small id="REG_NO_error" class="form-text text-danger"></small>
                    </div>
                    @csrf

                    <div class="form-group">
                    <label for="userpassword">Student Password</label>
                    <input type="password" class="form-control " name="STD_PASSWORD" placeholder="Enter STUDENT PASSWORD">
                    <small id="STD_PASSWORD_error" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group row m-t-20">
                    <div class="col-6">
                    <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customControlInlineS" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="customControlInlineS">Remember me</label>
                    </div>
                    </div>
                    <div class="col-6 text-right">
                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                    </div>
                    </div>

                    <div class="form-group m-t-10 mb-0 row">
                    <div class="col-12 m-t-20">
                    <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
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

<div class="m-t-40 text-center">
    <p class="text-muted">© 2020 School.<i class="mdi mdi-heart text-primary"></i> by Kelex</p>
</div>

</div>

@endsection
@section('customscript')
<script>
 $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$('body').on('submit','#Adminloginform',function(e){
      e.preventDefault();
      $('#username_error').text('');
      $('#password_error').text('');
      $('#Adminlogin_error').text('');
      var fdata = new FormData(this);
      $(this).find('submit').attr('disabled',true).html('<div class="spinner-border spinner-border-sm text-light" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
        url: '{{route("adminLogin")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
              
               console.log(data)
               if ($.trim(data) == '' ) {

                $("#Adminlogin_error").text('These credentials do not match our records.');
                  }
                  else
                  {

                  window.location=data.url;

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
       $(this).find('submit').html('Login').attr('disabled',false);;
    });
    $('body').on('submit','#Teacherloginform',function(e){
      e.preventDefault();
      $('#EMP_NO_error').text('');
      $('#PASSWORD_error').text('');
      $('#teacherlogin_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{route("loginteacher")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
              //return false;
               console.log(data)
               if ($.trim(data) == '' ) {
                $("#teacherlogin_error").text('These credentials do not match our records.');
                  }
                  else
                  {
                    window.location=data.url;

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
    $('body').on('submit','#Studentloginform',function(e){
      e.preventDefault();
      $('#REG_NO_error').text('');
      $('#STD_PASSWORD_error').text('');
      $('#studentlogin_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{route("loginstudent")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
              
               console.log(data)
               if ($.trim(data) == '' ) {
                $("#studentlogin_error").text('These credentials do not match our records.');
                  }
                  else
                  {
                    window.location=data.url;

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
</script>

@endsection
