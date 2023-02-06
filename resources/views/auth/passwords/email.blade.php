@extends('layouts.app')

@section('content')
<div class="wrapper-page">

<div class="card">
    <div class="card-body">

        <h3 class="text-center m-0">
            <a href="{{ route('password.request')}}" class="logo logo-admin"><img src="assets/images/logo.png" height="30" alt="logo"></a>
        </h3>

        <div class="p-3">
            <h4 class="text-muted font-18 mb-3 text-center">Reset Password</h4>
            <div class="alert alert-info" role="alert">
                Enter your Email and instructions will be sent to you!
            </div>

            <form class="form-horizontal m-t-30" action="{{route('password.email') }}">

                <div class="form-group">
                    <label for="useremail">Email</label>
                    <input type="email" class="form-control" id="useremail" placeholder="Enter email">
                </div>

                <div class="form-group row m-t-20">
                    <div class="col-12 text-right">
                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Reset</button>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

<div class="m-t-40 text-center">
    <p class="text-muted">Remember It ? <a href="{{ route('login') }}" class="text-white"> Sign In Here </a> </p>
    <p class="text-muted">© 2018 Agroxa. Crafted with <i class="mdi mdi-heart text-primary"></i> by Themesbrand</p>
</div>

</div>
@endsection
