<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Stack Multipurpose HTML Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Site Description Here">
        <link href="{{asset('school_website_asset/css/bootstrap.css')}}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{asset('school_website_asset/css/stack-interface.css')}}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{asset('school_website_asset/css/socicon.css')}}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{asset('school_website_asset/css/iconsmind.css')}}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{asset('school_website_asset/css/theme.css')}}" rel="stylesheet" type="text/css" media="all" />

        <link href="{{asset('css/lightbox.min.css" rel="stylesheet" type="text/css')}}" media="all" />
        <link href="{{asset('css/flickity.css" rel="stylesheet" type="text/css')}}" media="all" />
        <link href="{{asset('css/jquery.steps.css" rel="stylesheet" type="text/css')}}" media="all" />
        <link href="{{asset('css/font-rubiklato.css" rel="stylesheet" type="text/css')}}" media="all" />

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:200,300,400,400i,500,600,700%7CMerriweather:300,300i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        @yield('page-css')
    </head>
    <body class=" " data-smooth-scroll-offset='64'>
        <a id="start"></a>

<!-- header below -->
@include('Schoolwebsite.Layout.header')
@yield('content')
@include('Schoolwebsite.Layout.footer')
</div>
        <!--<div class="loader"></div>-->
        <a class="back-to-top inner-link" href="#start" data-scroll-class="100vh:active">
            <i class="stack-interface stack-up-open-big"></i>
        </a>
        <script src="{{asset('school_website_asset/js/jquery-3.1.1.min.js')}}"></script>
        <script src="{{asset('school_website_asset/js/typed.min.js')}}"></script>
        <script src="{{asset('school_website_asset/js/isotope.min.js')}}"></script>
        <script src="{{asset('school_website_asset/js/granim.min.js')}}"></script>
        <script src="{{asset('school_website_asset/js/smooth-scroll.min.js')}}"></script>
        <script src="{{asset('school_website_asset/js/scripts.js')}}"></script>
    </body>
</html>
