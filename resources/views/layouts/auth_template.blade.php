<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" dir="rtl">
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
    <link href="{{ asset('assets') }}/global/plugins/bootstrap-switch/css/bootstrap-switch-rtl.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ asset('assets') }}/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets') }}/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
@yield('pageStyle')

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('assets') }}/global/css/components-rtl.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('assets') }}/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ asset('assets') }}/pages/css/login-4-rtl.min.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets') }}/global/pages/lang_ar.js" type="text/javascript"></script>
    @yield('head')

<!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> </head>
<!-- END HEAD -->

<body class=" login">
    <div class="logo">
        <a href="index.html">
            <img src="../assets/pages/img/Maqal Talal.png" alt="" />
        </a>
    </div>
        @yield('content')
    <div class="copyright"> 2020 © {{ trans('common.project_name') }} </div>
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
<!-- END CORE PLUGINS -->
<script src="{{ asset('assets') }}/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
@yield('pageLevelPluginJS')
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ asset('assets') }}/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

@yield('pageLevelJS')
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ asset('assets') }}/global/pages/login.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->

<script>
    jQuery(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    });
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
