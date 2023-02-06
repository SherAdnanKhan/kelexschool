<div class="nav-container">
            <div class="via-1607079052382" via="via-1607079052382" vio="Homke">
                <div class="bar bar--sm visible-xs">
                    <div class="container">
                        <div class="row">
                            <div class="col-3 col-md-2">
                                <a href="{{URL::current()}}"> <img class="logo logo-dark" alt="logo" src="{{asset('school_website_asset/img/logo-dark.png')}}"> <img class="logo logo-light" alt="logo" src="{{asset('school_website_asset/img/logo-light.png')}}"> </a>
                            </div>
                            <div class="col-9 col-md-10 text-right">
                                <a href="#" class="hamburger-toggle" data-toggle-class="#menu1;hidden-xs hidden-sm"> <i class="icon icon--sm stack-interface stack-menu"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <nav id="menu1" class="bar bar-1 hidden-xs">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-1 col-md-2 hidden-xs">
                                <div class="bar__module">
                                    <a href="{{URL::current()}}"> <img class="logo logo-dark" alt="logo" src="{{asset('school_website_asset/img/logo-dark.png')}}"> <img class="logo logo-light" alt="logo" src="{{asset('school_website_asset/img/logo-light.png')}}"> </a>
                                </div>
                            </div>
                            <div class="col-lg-11 col-md-12 text-right text-left-xs text-left-sm">
                                <div class="bar__module">
                                    <ul class="menu-horizontal text-left">
                                    <li> <a href="{{URL::current()}}">&nbsp;Home&nbsp;</a> </li>

                                    </ul>
                                </div>
                                <div class="bar__module">
                                <a class="btn btn--sm type--uppercase" href="{{route('login')}}#teacher-login"> <span class="btn__text">TEACHER LOGIN</span> </a>
                                    <a class="btn btn--sm btn--info type--uppercase" href="{{route('login')}}#student-login"> <span class="btn__text">STUDENT LOGIN<br></span> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
