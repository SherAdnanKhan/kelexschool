<div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left">
            <a href="#" class="logo">
                <span>
                    <img src="{{asset('assets/images/logo.png')}}" alt="" height="24">
                </span>
                <i>
                    <img src="{{asset('assets/images/logo-sm1.png')}}" alt="" height="22">
                </i>
            </a>

        </div>

        <nav class="navbar-custom">
            <ul class="navbar-right d-flex list-inline float-right mb-0">

                <li class="dropdown notification-list d-none d-sm-block">
                    <form role="search" class="app-search">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" placeholder="Search..">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </li>


                <li class="dropdown notification-list">
                    <!-- <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-bell noti-icon"></i>
                        <span class="badge badge-pill badge-info noti-icon-badge">3</span>
                    </a> -->

                </li>
                <li class="dropdown notification-list">
                    <div class="dropdown notification-list nav-pro-img">
                        <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{asset('assets/images/users/user-4.jpg')}}" alt="user" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle m-r-5"></i> Profile</a>
                            <a class="dropdown-item" href="#"><i class="mdi mdi-wallet m-r-5"></i> My Wallet</a>
                            <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-right">11</span><i class="mdi mdi-settings m-r-5"></i> Settings</a>
                            <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5"></i> Lock screen</a>
                            <div class="dropdown-divider"></div> -->

                            @if(Session::get('is_teacher'))
                            <a class="dropdown-item text-danger" href="{{ route('logoutteacher') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                 {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logoutteacher') }}" method="POST" class="d-none">
                                        @csrf
                            </form>

                            @elseif(Session::get('is_student'))

                                    <a class="dropdown-item text-danger" href="{{ route('logoutstudent') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                 {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logoutstudent') }}" method="POST" class="d-none">
                                        @csrf
                            </form>

                            @else
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                 {{ __('Logout') }}
                            </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            @endif
                        </div>
                    </div>
                </li>

            </ul>
            <ul class="list-inline menu-left mb-0">
                <li class="float-left">
                    <button class="button-menu-mobile open-left waves-effect waves-light">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>

            </ul>
            <ul class="list-inline menu-center mb-0">
                <li class="text-center text text-white">
            
                <p style="padding-top:15px;font-size:20px;text-transform: uppercase;"> <b> {{Session::get('schoolname')}} </b> </p>
                 </li>

            </ul>

        </nav>

</div>














