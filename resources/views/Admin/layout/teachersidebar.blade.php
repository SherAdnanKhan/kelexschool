   <!-- ========== Left Sidebar Start ========== -->
   <div class="left side-menu">
                <div class="slimscroll-menu" id="remove-scroll">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu" id="side-menu">
                            <li class="menu-title">Main</li>
                            <li>
                                <a href="{{route('dashboard')}}" class="waves-effect">
                                    <i class="mdi mdi-home"></i><span class="badge badge-primary float-right"></span> <span> Dashboard </span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-email"></i><span> Profile <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span></a>
                                <ul class="submenu">
                                
                                    <li><a href="{{route('get-employee-details',['employeeid' =>  Crypt::encryptString(Session::get('EMP_ID')) ])}}"> Teacher Details</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-email"></i><span> Application <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span></a>
                                <ul class="submenu">
                               
                                    <li><a href=" {{route('TeacherApplication')}}"> Add New Application</a></li>
                                    <li><a href=" {{route('Teacher_View_Application')}}"> View Application Status</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-email"></i><span> Papers <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span></a>
                                <ul class="submenu">
                               
                                    <li><a href=" {{route('UploadPaperTeacher')}}"> Upload Paper</a></li>
                                    <li><a href=" {{route('Paperattendance')}}"> Paper Attendance</a></li>
                                    <li><a href=" {{route('Paper')}}"> Add Marks</a></li>
                                    <!-- <li><a href=" {{route('View_marks')}}"> View Marks</a></li> -->
                              
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-black-mesa"></i> <span>TimeTable <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span> </a>
                                <ul class="submenu">
                                    <li><a href="{{route('showtimetableteacher')}}">View TimeTable</a></li>

                                </ul>
                            </li>


                        </ul>

                    </div>
                    <!-- Sidebar -->
                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->
            <div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">

                </div>
            </div>
