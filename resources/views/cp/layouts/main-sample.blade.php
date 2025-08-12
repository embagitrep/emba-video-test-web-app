<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="apple-touch-icon" href="{{ url('/app-assets/images/ico/apple-icon-120.html') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/favicon.png') }}">
    <link
            href="{{ url('/app-assets/css/cssc203.css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700') }}"
            rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/jstree/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/forms/select/select2.min.css') }}">


    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/components.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/themes/dark-layout.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/themes/semi-dark-layout.min.css') }}">
    <!-- END: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/extensions/toastr.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
          href="{{ url('/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <!-- END: Page CSS-->
    <style>
        .contextpanel {
            overflow: auto;
            position: absolute;
            top: 51px;
            left: 240px;
            background-color: white;
            width: auto;
            height: 1000px;
            z-index: 1;
            border: 1px solid #cacaca;
            border-top: none;
            display: none;
            margin-left: 20px;
            min-width: 163px;
            padding: 20px 0;
        }

        .actionpanel {
            left: 480px;
            background-color: #e4e7ea;
            border-left: none;
        }

        .contextpanel2 {
            margin-left: 0;
            padding: 20px 15px;
        }

        .actionpanel .action {
            margin: 10px 0;
        }
    </style>


    @stack('css')


</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body
        class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow 2-columns calendar-application navbar-sticky footer-static  "
        data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">



@yield('content')


<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0"><span class="float-left d-inline-block">{{ date('Y') }} &copy; Admin</span>
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button>
    </p>
</footer>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="{{ url('/app-assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ url('/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ url('/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js') }}"></script>
<script src="{{ url('/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js') }}"></script>
<script src="{{ url('/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script>
<!-- BEGIN Vendor JS-->


<!-- BEGIN: Theme JS-->
<script src="{{ url('/app-assets/js/scripts/configs/vertical-menu-light.min.js') }}"></script>
<script src="{{ url('/app-assets/js/core/app-menu.min.js') }}"></script>
<script src="{{ url('/app-assets/js/core/app.min.js') }}"></script>
<script src="{{ url('/app-assets/js/scripts/components.min.js') }}"></script>
<script src="{{ url('/app-assets/js/scripts/footer.min.js') }}"></script>
<script src="{{ url('/app-assets/js/scripts/customizer.js?v=1') }}"></script>
<script src="{{ url('/app-assets/vendors/js/jstree.min.js') }}"></script>
<script src="{{ url('/app-assets/js/scripts/tree-action.js') }}"></script>

<script src="{{ url('/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>


<!-- END: Theme JS-->

@stack('scripts')


</body>
<!-- END: Body-->

</html>
