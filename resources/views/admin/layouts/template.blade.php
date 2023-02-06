<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title') | {{ env('APP_NAME') }}</title>


    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <!--end::Page Custom Styles -->
   
    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{ asset('assets/css/skins/header/base/light.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/skins/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/skins/brand/dark.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/skins/aside/dark.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{ asset('images/LogoIconGold.png')}}" />

    @yield('pageStyle')

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />

    @yield('head')

</head>
	<!-- end::Head -->
  <!-- begin::Body -->
   <!-- begin::Body -->
   <body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

    <!-- begin:: Page -->

    @include('admin.elements.header-mobile')

    <div class="kt-grid kt-grid--hor kt-grid--root">
      <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

        @include('admin.elements.sidebar')

        <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

          @include('admin.elements.header')

          <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
            <!-- begin:: Content -->
            @yield('content_head')
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
              <div class="kt-portlet__body kt-portlet__body--fit">
                @yield('content')
              </div>
            </div>
            <!-- end:: Content -->
          </div>
          
          @include('admin.elements.footer')
        </div>
      </div>
    </div>

    <!-- end:: Page -->

    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
      <i class="fa fa-arrow-up"></i>
    </div>

    <!-- begin::Global Config(global config for global JS sciprts) -->
    <script>
      var KTAppOptions = {
        "colors": {
          "state": {
            "brand": "#5d78ff",
            "dark": "#282a3c",
            "light": "#ffffff",
            "primary": "#5867dd",
            "success": "#34bfa3",
            "info": "#36a3f7",
            "warning": "#ffb822",
            "danger": "#fd3995"
          },
          "base": {
            "label": [
              "#c5cbe3",
              "#a1a8c3",
              "#3d4465",
              "#3e4466"
            ],
            "shape": [
              "#f0f3ff",
              "#d9dffa",
              "#afb4d4",
              "#646c9a"
            ]
          }
        }
      };
    </script>

    <!-- end::Global Config -->

    <!--begin::Global Theme Bundle(used by all pages) -->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts -->

    @yield('pageJs')
  </body>

  

</html>
