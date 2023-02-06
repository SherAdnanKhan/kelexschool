@extends('layouts.app')

@section('content')
<div class="wrapper-page">

<div class="card">
    <div class="card-body">

        {{-- <h3 class="text-center m-0">
            <a href="{{ route('login') }}" class="logo logo-admin"><img src="assets/images/collabs_logo.png" height="30" alt="logo"></a>
        </h3> --}}

        <div class="p-3">
            <h4 class="text-muted font-18 m-b-5 text-center">Welcome Back !</h4>
            <p class="text-muted text-center">Sign in to continue.</p>

            <form class="form-horizontal m-t-30" method='Post'action="{{ route('login') }}">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Enter username">
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                    @csrf

                <div class="form-group">
                    <label for="userpassword">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row m-t-20">
                    <div class="col-6">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customControlInline" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customControlInline">Remember me</label>
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

<div class="m-t-40 text-center">
    <p class="text-muted">© 2020 School.<i class="mdi mdi-heart text-primary"></i> by Kelex</p>
</div>

</div>

@endsection
