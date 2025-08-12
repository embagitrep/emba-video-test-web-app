<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Admin - Login Page</title>
    <link rel="apple-touch-icon" href="{{ url('/app-assets/images/ico/apple-icon-120.html') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/app-assets/images/ico/favicon.ico') }}">
    <link href="{{ url('/app-assets/css/cssc203.css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700') }}" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/components.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/themes/dark-layout.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/themes/semi-dark-layout.min.css') }}">
    <!-- END: Theme CSS-->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/pages/authentication.css') }}">
    <!-- END: Page CSS-->


</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
<!-- BEGIN: Content-->
@yield('content')
<!-- END: Content-->


<!-- BEGIN: Vendor JS-->
<script src="{{ url('/app-assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ url('/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js') }}"></script>
<script src="{{ url('/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js') }}"></script>
<script src="{{ url('/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ url('/app-assets/js/core/app-menu.min.js') }}"></script>
<script src="{{ url('/app-assets/js/core/app.min.js') }}"></script>
<script src="{{ url('/app-assets/js/scripts/components.min.js') }}"></script>
<script src="{{ url('/app-assets/js/scripts/footer.min.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
