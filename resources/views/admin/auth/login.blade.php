@extends('admin.layouts.auth_template')
@section('page_title', 'Sign In')

@section('content')

<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
  <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url({{ asset('assets/media/bg/bg-3.jpg') }});">
    <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
      <div class="kt-login__container">
        <div class="kt-login__logo">
          <a href="#">
            <svg style='width:100px' viewBox="10 300 720 720">
              <g id=“layer1”>
                <g style=
                  'fill: rgb(255,255,255),
                  fillOpacity: 1.0,
                  strokeLinejoin: miter'
                >
                  <animate attributeName=“fill” values=“white;gold;orange;red;purple;dodgerblue;limegreen;gray;white” dur=“20s” repeatCount=“indefinite” />
                  <path d="M620.07184,606.9308C620.0985,606.9308,620.1202,606.95245,620.1202,606.9791L620.1202,606.9801C620.1202,607.0068,620.0984,607.02844,620.07184,607.02844C620.0453,607.02844,620.0235,607.0068,620.0235,606.9801L620.0235,606.9791C620.0235,606.95245,620.04517,606.9308,620.07184,606.9308 Z M427.60413,461.24298L427.5181,461.27954L81.33351,820.5979L81.3327,820.5979C81.30978,820.62006,81.29623,820.6509,81.29623,820.68384L81.29674,820.68384C81.29673,820.6858,81.29677,820.6878,81.29686,820.68976L81.296326,820.68976C81.29795,820.7292,81.318924,820.7649,81.35162,820.78564L81.35081,820.78564L253.79988,969.7546C253.82199,969.7737,253.84981,969.7836,253.87798,969.7836C253.8939,969.7836,253.90994,969.78046,253.92513,969.7739C253.93936,969.7678,253.95198,969.7591,253.96254,969.74854L253.96165,969.74854C575.28424,654.72925,590.58093,642.2862,590.89886,642.0362L590.9323,641.9904L590.90515,642.0302C607.9407,626.7547,628.73315,605.63525,628.7686,605.59924C643.7954,590.3354,644.665,578.54016,638.56445,572.5344C635.68384,569.6985,631.253,568.16296,626.05084,568.16296C621.0419,568.16296,615.30927,569.5859,609.53284,572.651C600.68884,577.3438,585.4446,584.843,568.25726,592.58295C568.2446,592.5886,568.23334,592.5963,568.22375,592.6055L568.2181,592.6055L370.2529,686.32227C380.82422,661.2362,389.66858,639.8873,397.5274,620.9174C403.79028,605.7998,409.4297,592.18744,414.78308,579.484C421.03827,564.64075,426.9139,551.01117,433.00153,537.5172C453.1898,492.7674,443.49255,476.71405,427.6919,461.27698L427.6084,461.24298 Z" />
                </g>
                <g style= 'fill:rgb(255, 255, 255), fillOpacity: 1.0, strokeLinejoin: miter' >
                  <animate attributeName=“fill” values=“white;gold;orange;red;purple;dodgerblue;limegreen;gray;white” dur=“20s” repeatCount=“indefinite” />
                  <path d="M374.9392,349.86795C350.5268,349.86795,324.06268,354.41058,299.25403,365.56796C221.53807,400.51978,182.74506,448.97232,168.82213,486.225C159.55989,511.0074,166.52519,542.1733,181.48453,559.16675C194.63486,574.1052,213.28955,577.0818,226.08353,577.0818C233.55574,577.0818,239.03452,576.0671,240.2723,575.81976C253.03828,573.26886,271.18698,566.5961,287.0835,548.2826C287.31335,548.0178,287.52148,547.7803,287.72427,547.54877L287.72433,547.5487C287.72433,547.5487,287.73602,547.53534,287.74045,547.53033L287.74042,547.53033L287.74243,547.52814L287.74445,547.52594L287.74622,547.5239C291.41296,543.33905,291.5174,543.2133,324.6763,491.12064C325.68073,489.5427,326.73837,487.9931,327.84747,486.46948C346.88123,460.32227,380.69934,442.42108,406.10757,442.42108C414.39993,442.42108,421.78745,444.32785,427.47305,448.46664C458.20334,470.83658,454.18738,497.0039,451.34012,512.65234C449.99124,520.0658,443.84177,535.30133,431.29074,564.6833C427.75812,572.9531,423.72137,582.33685,419.1397,592.98724C413.16647,606.8723,406.17767,623.11865,398.2629,641.64716C398.2409,641.6987,396.22223,646.4283,387.63,667.211C387.61478,667.24786,387.61896,667.2899,387.6411,667.32306C387.65564,667.3448,387.6767,667.36084,387.7007,667.3693L387.69684,667.3693C387.7034,667.3718,387.71024,667.37384,387.71735,667.3752C387.72482,667.37665,387.73233,667.3773,387.73972,667.3773C387.75735,667.3773,387.77454,667.37335,387.79025,667.3657L387.7891,667.3657L427.52652,649.63293L427.5096,649.6386L427.5926,649.56836C445.01105,607.2287,458.61633,574.9092,468.91003,550.45654C480.6348,522.60443,488.0853,504.90564,492.03174,494.1098C499.4481,473.82175,503.094,450.82343,491.97433,421.04214C484.43893,400.86032,472.53033,384.71783,456.3396,371.74582C440.65552,359.17975,409.89014,349.86795,374.9392,349.86795 Z" />
                </g>
              </g>
            </svg>
          </a>
        </div>
        <div class="kt-login__signin">
          <div class="kt-login__head">
            <h3 class="kt-login__title">Sign In To Admin</h3>
          </div>
          <form class="kt-form login-form" method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
            </div>
            <div class="input-group">
              <input class="form-control" type="password" placeholder="Password" name="password">
            </div>
            <div class="row kt-login__extra">
              <div class="col">
                <label class="kt-checkbox">
                  <input type="checkbox" name="remember"> Remember me
                  <span></span>
                </label>
              </div>
              <div class="col kt-align-right">
                <a href="javascript:;" id="kt_login_forgot" class="kt-login__link">Forget Password ?</a>
              </div>
            </div>
            <div class="kt-login__actions">
              <button id="kt_login_signin_submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Sign In</button>
            </div>
          </form>
        </div>
        <div class="kt-login__signup">
          <div class="kt-login__head">
            <h3 class="kt-login__title">Sign Up</h3>
            <div class="kt-login__desc">Enter your details to create your account:</div>
          </div>
          <form class="kt-form">
            @csrf
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Fullname" name="fullname">
            </div>
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
            </div>
            <div class="input-group">
              <input class="form-control" type="password" placeholder="Password" name="password">
            </div>
            <div class="input-group">
              <input class="form-control" type="password" placeholder="Confirm Password" name="rpassword">
            </div>
            <div class="row kt-login__extra">
              <div class="col kt-align-left">
                <label class="kt-checkbox">
                  <input type="checkbox" name="agree">I Agree the <a href="#" class="kt-link kt-login__link kt-font-bold">terms and conditions</a>.
                  <span></span>
                </label>
                <span class="form-text text-muted"></span>
              </div>
            </div>
            <div class="kt-login__actions">
              <button id="kt_login_signup_submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Sign Up</button>&nbsp;&nbsp;
              <button id="kt_login_signup_cancel" class="btn btn-light btn-elevate kt-login__btn-secondary">Cancel</button>
            </div>
          </form>
        </div>
        <div class="kt-login__forgot">
          <div class="kt-login__head">
            <h3 class="kt-login__title">Forgotten Password ?</h3>
            <div class="kt-login__desc">Enter your email to reset your password:</div>
          </div>
          <form class="kt-form" action="">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
            </div>
            <div class="kt-login__actions">
              <button id="kt_login_forgot_submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Request</button>&nbsp;&nbsp;
              <button id="kt_login_forgot_cancel" class="btn btn-light btn-elevate kt-login__btn-secondary">Cancel</button>
            </div>
          </form>
        </div>
        <!-- <div class="kt-login__account">
          <span class="kt-login__account-msg">
            Don't have an account yet ?
          </span>
          &nbsp;&nbsp;
          <a href="javascript:;" id="kt_login_signup" class="kt-login__account-link">Sign Up!</a>
        </div> -->
      </div>
    </div>
  </div>
</div>

@endsection
