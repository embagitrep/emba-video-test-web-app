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


<!-- BEGIN: Header-->
<div class="header-navbar-shadow"></div>
<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <div class="menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>
                </div>


                <ul class="nav navbar-nav float-right">

                    <li class="nav-item dropdown">
                        <a class="nav-link " style="padding: 1.5rem .75rem 1.15rem;" href="javascript:void(0);" data-toggle="dropdown" aria-expanded="true">
                            <i class="bx bx-sm bx-moon"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-styles" data-popper="static">
                            <li>
                                <a class="dropdown-item layout-name" href="javascript:void(0);" data-layout="">
                                    <span class="align-middle"><i class="bx bx-sun me-2"></i>Light</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item layout-name" href="javascript:void(0);" data-layout="dark-layout">
                                    <span class="align-middle"><i class="bx bx-moon me-2"></i>Dark</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item layout-name" href="javascript:void(0);" data-layout="system">
                                    <span class="align-middle"><i class="bx bx-desktop me-2"></i>System</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <?php
                        $notifService = new \App\Services\CP\Notification\NotificationService();
                        $hasNotif = $notifService->hasNotifications();
                    ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link " style="padding: 1.5rem .75rem 1.15rem;" href="javascript:void(0);" data-toggle="dropdown" aria-expanded="true">
                            <i class="bx bx-sm bx-bell"></i>
                            @if($hasNotif)
                            <span class="badge bg-danger js--notifCount rounded-pill position-absolute text-white" style="top: 15px;right: 5px">{{ $notifService->getUnreadNotificationsCount() }}</span>
                            @endif
                        </a>
                        @if($hasNotif)
                        <ul class="dropdown-menu dropdown-menu-end dropdown-styles dropdown-notification pb-0" data-popper="static">

                            @foreach($notifService->getUnreadNotifications() as $notification)
                                <li class="dropdown-item">
                                  <div class="d-flex">
                                      <div class="flex-grow-1">
                                          <h6 class="media-heading">
                                              <a href="{{ $notification->data['url']??'#' }}" class="text-muted js--viewNotification">{{ $notification->data['title'] }}</a>
                                          </h6>
                                          <p class="notification-text">{{ \Illuminate\Support\Str::limit($notification->data['body']) }}</p>
                                          <small class="text-muted">{{ \Carbon\Carbon::make($notification->created_at)->shortRelativeDiffForHumans() }}</small>
                                      </div>
                                      <div class="flex-shrink-0 dropdown-notifications-actions ml-1 d-flex flex-column align-items-center">
                                          <a href="{{ route('admin.notifications.markAsRead',['id' => $notification->id]) }}" class="dropdown-notifications-read js--notifMarkAsRead">
                                              <span class="badge badge-circle badge-circle-primary badge-circle-xs"> </span>
                                          </a>
                                          <a href="{{ route('admin.notifications.delete',['id' => $notification->id]) }}" class="dropdown-notifications-archive js--notifDelete"><span class="bx bx-x"></span></a>
                                      </div>
                                  </div>
                                </li>
                            @endforeach

                            <li class="dropdown-menu-footer border-top">
                                <a href="{{ route('admin.notifications.markAllAsRead') }}" class="dropdown-item d-flex justify-content-center js--notifMarkAllAsRead">
                                    Mark all as read
                                </a>
                            </li>

                        </ul>
                        @endif
                    </li>

                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                    class="ficon bx bx-fullscreen"></i></a></li>


                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                {{--                                <span class="user-name">{{ Auth::user()->name }}</span>--}}
                                {{--<span class="user-status text-muted">Available</span>--}}
                            </div>
                            <span>
                                <img class="round" src="{{ url('app-assets/images/profile/user1.jpg') }}" alt="avatar"
                                     height="40" width="40">
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pb-0">
                            {{--<a class="dropdown-item"
                               href="{{ route('profile', ['username' => Auth::user()->username?Auth::user()->username:Auth::user()->email]) }}">
                                <i class="bx bx-user mr-50"></i>
                                Edit Profile
                            </a>--}}
                            {{--<div class="dropdown-divider mb-0"></div>--}}
                            <a class="dropdown-item" href="javascript:void(0)" onclick="submitLogout()"><i
                                        class="bx bx-power-off mr-50"></i> Logout</a>
                            {{--                            <form action="{{ route('logout') }}" style="display: none" method="post" id="logoutForm">--}}
                            {{--                                {{ csrf_field() }}--}}
                            {{--                                <button type="submit"></button>--}}
                            {{--                            </form>--}}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->

<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('admin.index') }}">
                    {{--                    <div class="venue-logo"></div>--}}
                    <img src="{{ url('/client/favicon.png') }}" alt="">
                    <h2 class="brand-text mb-0">Admin</h2></a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                            class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                            class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                            data-ticon="bx-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main sidebaritems" id="main-menu-navigation" data-menu="menu-navigation"
            data-icon-style="">
            <li class=" nav-item">
                <a href="{{ route('admin.index') }}">
                    <i class="bx bx-home-alt"></i>
                    <span class="menu-title" data-i18n="Dashboard">Dashboard</span>
                </a>
            </li>



            <li class=" navigation-header"><span>Merchants</span></li>
            <li class=" nav-item has-sub {{ request()->is('merchants/*') ? 'sidebar-group-active open' :'' }}">
                <a href="#"><i class="bx bx-spreadsheet"></i><span class="menu-title" data-i18n="Merchants">Merchants</span></a>
                <ul class="menu-content">

                    <li class="{{ request()->is('merchants') ? 'active' :'' }}">
                        <a href="{{ route('admin.merchant.index') }}"><i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item" data-i18n="All">All</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item has-sub {{ request()->is('orders/*') ? 'sidebar-group-active open' :'' }}">
                <a href="#"><i class="bx bx-spreadsheet"></i><span class="menu-title" data-i18n="Video Records">Video Records</span></a>
                <ul class="menu-content">

                    <li class="{{ request()->is('orders') ? 'active' :'' }}">
                        <a href="{{ route('admin.orders.index') }}"><i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item" data-i18n="All">All</span>
                        </a>
                    </li>
                </ul>
            </li>


            <li class=" navigation-header"><span>Site</span></li>
            <li class=" nav-item has-sub {{ request()->is('sent-sms/*') ? 'sidebar-group-active open' :'' }}">
                <a href="#"><i class="bx bx-spreadsheet"></i><span class="menu-title" data-i18n="Sent SMS">Sent SMS</span></a>
                <ul class="menu-content">

                    <li class="{{ request()->is('sent-sms') ? 'active' :'' }}">
                        <a href="{{ route('admin.sent.sms.index') }}"><i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item" data-i18n="All">All</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item {{ request()->is('settings') ? 'sidebar-group-active open' :'' }}">
                <a href="#"><i class="bx bx-list-ul"></i><span class="menu-title"
                                                               data-i18n="Setting">Settings</span></a>
                <ul class="menu-content">

                    <li class="{{ request()->is('settings/*') ? 'active' :'' }}">
                        <a href="{{ route('admin.settings') }}"><i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item" data-i18n="Settings">Site Settings</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item {{ request()->is('translations') ? 'sidebar-group-active open' :'' }}">
                <a href="#"><i class="bx bx-globe"></i><span class="menu-title"
                                                             data-i18n="Translations">Translations</span></a>
                <ul class="menu-content">

                    <li class="{{ request()->is('translations/*') ? 'active' :'' }}">
                        <a href="{{ route('admin.translations') }}"><i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item" data-i18n="All">All</span>
                        </a>
                    </li>
                </ul>
            </li>



            <li class=" nav-item {{ request()->is('user') ? 'sidebar-group-active open' :'' }}">
                <a href="#"><i class="bx bx-user"></i><span class="menu-title"
                                                            data-i18n="Users">Users</span></a>
                <ul class="menu-content">

                    <li class="{{ request()->is('user/all') ? 'active' :'' }}">
                        <a href="{{ route('user.all') }}"><i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item" data-i18n="All">All</span>
                        </a>
                    </li>
                    <li class="{{ request()->is('user/all?type=admin') ? 'active' :'' }}">
                        <a href="{{ route('user.all',['type' => 'admin']) }}"><i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item" data-i18n="All">Admin</span>
                        </a>
                    </li>
                    <li class="{{ request()->is('user/all?type=manager') ? 'active' :'' }}">
                        <a href="{{ route('user.all',['type' => 'manager']) }}"><i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item" data-i18n="All">Bank Manager</span>
                        </a>
                    </li>
                    <li class="{{ request()->is('user/all?type=manager') ? 'active' :'' }}">
                        <a href="{{ route('user.all',['type' => 'user']) }}"><i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item" data-i18n="All">Users</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        @yield('content')
    </div>
</div>


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
<script>
    function submitLogout() {
        $('#logoutForm').submit()
    }

    $('.dropdown span.bx-dots-vertical-rounded').click(function () {
        $('.dropdown-menu').removeClass('show');
        $(this).next('.dropdown-menu').addClass('show')
    });
</script>

@stack('scripts')

<script>
    $('body').on('click', '.js-btnDelete', function (e) {
        e.preventDefault();
        $res = confirm('Are you sure to delete?');
        if ($res) {
            $(this).parent('form').bind().submit()
        }
    })

    let tmpTabUrl = window.location.href;

    $('.nav.nav-tabs.nav-fill .nav-item .nav-link').on('click', function () {
        let id = $(this).attr('id'), target = $(this).attr('href');
        let tmp = JSON.stringify({
            'id': id,
            'target': target
        })

        localStorage.setItem(tmpTabUrl, tmp)
    })


    $(document).ready(function () {
        let tmpTabData = JSON.parse(localStorage.getItem(tmpTabUrl))

        if (tmpTabData != null) {
            $('.nav.nav-tabs.nav-fill .nav-item .nav-link').removeClass('active')
            $('.tab-pane').removeClass('active')
            $('#' + tmpTabData.id + '').addClass('active');
            $('' + tmpTabData.target + '').addClass('active');
        }

    })


    $('.js--notifMarkAsRead').click(function (e) {
        e.preventDefault();
        let url = $(this).attr('href'), _this = $(this)

        $.ajax({
            url,
            success: function (data) {
                if(data.success){
                    _this.remove()
                }
            }
        })
    })

    $('.js--viewNotification').click(function (e) {
      e.preventDefault();
      let _this = $(this), url = _this.attr('href');

      _this.parents('.dropdown-item').find('.js--notifMarkAsRead').click();

      setTimeout(function () {
          window.location = url
      },100)

    })


    $('.js--notifDelete').click(function (e) {
        e.preventDefault();
        let url = $(this).attr('href'), _this = $(this)

        $.ajax({
            url,
            success: function (data) {
                if(data.success){
                    _this.parents('.dropdown-item').remove()
                }
            }
        })
    })

    $('.js--notifMarkAllAsRead').click(function (e) {
        e.preventDefault();
        let url = $(this).attr('href'), _this = $(this)

        $.ajax({
            url,
            success: function (data) {
                if(data.success){
                    $('.dropdown-notification').find('.js--notifMarkAsRead').remove()
                    $('.js--notifCount').remove()
                }
            }
        })
    })

</script>

</body>
<!-- END: Body-->

</html>
