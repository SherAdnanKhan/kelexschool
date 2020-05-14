<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ar" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>@yield('page_title') | {{ trans('common.project_name') }} </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/global/plugins/bootstrap/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />

    @yield('pageStyle')
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('assets') }}/global/css/components-rtl.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('assets') }}/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ asset('assets') }}/layouts/layout2/css/layout-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/layouts/layout2/css/themes/blue.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ asset('assets') }}/custom/css/custom-rtl.css" rel="stylesheet" type="text/css" />
    @yield('head')
    <script src="{{ asset('assets') }}/global/pages/lang_ar.js" type="text/javascript"></script>
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> </head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
<!-- BEGIN HEADER -->
@include('elements.header')
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        @include('elements.sidebar')
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            @yield('content')
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner">
        <a target="_blank" href="/">2020 &copy; {{ trans('common.project_name') }}</a>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <!-- END FOOTER -->
</div>
@include('elements.popups')
    <!-- END QUICK NAV -->
    <!--[if lt IE 9]>
    <script src="{{ asset('assets') }}/global/plugins/respond.min.js"></script>
    <script src="{{ asset('assets') }}/global/plugins/excanvas.min.js"></script>
    <script src="{{ asset('assets') }}/global/plugins/ie8.fix.min.js"></script>
    <![endif]-->
    <!-- BEGIN CORE PLUGINS -->
    <script src="{{ asset('assets') }}/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>

    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
@yield('pageLevelPluginJS')
   <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{ asset('assets') }}/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->

@yield('pageLevelJS')
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="{{ asset('assets') }}/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
    <script>
        $(document).ready(function()
        {
            $('#clickmewow').click(function()
            {
                $('#radio1003').attr('checked', 'checked');
            });
        })
    </script>
</body>

</html>
