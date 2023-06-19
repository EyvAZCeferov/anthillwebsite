<!DOCTYPE html>
<html class=" ">

<head>

    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>@yield('title', env('IMAGE_WATERMARKER_WRITE') . ' Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="EyvAZCeferov by Markotic Studio" name="author" />

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" /> <!-- Favicon -->
    <link rel="apple-touch-icon-precomposed" href="{{ asset('assets/images/apple-touch-icon-57-precomposed.png') }}">
    <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ asset('assets/images/apple-touch-icon-114-precomposed.png') }}">
    <!-- For iPhone 4 Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="{{ asset('assets/images/apple-touch-icon-72-precomposed.png') }}">
    <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ asset('assets/images/apple-touch-icon-144-precomposed.png') }}">
    <!-- For iPad Retina display -->

    <!-- CORE CSS FRAMEWORK - START -->
    <link href="{{ asset('assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css"
        media="screen" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/fonts/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <link href="{{ asset('assets/plugins/jquery-ui/smoothness/jquery-ui.min.css') }}" rel="stylesheet" type="text/css"
        media="screen" />
    <link href="{{ asset('assets/plugins/icheck/skins/minimal/white.css') }}" rel="stylesheet" type="text/css"
        media="screen" />
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE CSS TEMPLATE - START -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="{{ asset("build/assets/app-be1c2ea0.css ") }}">
    @yield('css')

</head>
<!-- END HEAD -->

<body class=" ">
    <!-- START TOPBAR -->
    <div class='page-topbar '>
        <div class='quick-area'>
            <div style="width:55px"></div>

            <div class='pull-left'>
                <ul class="info-menu left-links list-inline list-unstyled">
                    <li class="sidebar-toggle-wrap">
                        <a href="#" data-toggle="sidebar" class="sidebar_toggle">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>


                </ul>
            </div>
            <div class='pull-right'>
                <ul class="info-menu right-links list-inline list-unstyled">
                    <li class="profile showopacity">
                        <a href="#" data-toggle="dropdown" class="toggle">

                            <span>
                                @auth
                                    {{ Auth::user()->name_surname }}
                                @endauth
                                @guest
                                    İstifadəçi adı
                                @endguest

                                <i class="fa fa-angle-down"></i></span>
                        </a>
                        <ul class="dropdown-menu profile animated fadeIn">
                            <li>
                                <a href="{{ route('settings.index') }}">
                                    <i class="fa fa-wrench"></i>
                                    Parametrlər
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('auth.logout') }}">
                                    <i class="fa fa-lock"></i>
                                    Çıxış
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
            <div style="width:55px"></div>
        </div>

    </div>
    <!-- END TOPBAR -->

    <!-- START CONTAINER -->
    <div class="page-container row-fluid">

        <!-- SIDEBAR - START -->
        <div class="page-sidebar ">

            <!-- MAIN MENU - START -->
            <div class="page-sidebar-wrapper" id="main-menu-wrapper">

                <!-- USER INFO - START -->
                <div class="profile-info row">

                    <div class="profile-image col-md-4 col-sm-4 col-xs-4">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('assets/images/adminUser.webp') }}" class="img-responsive img-circle">
                        </a>
                    </div>

                    <div class="profile-details col-md-8 col-sm-8 col-xs-8">

                        <h3>
                            <a href="{{ route('dashboard') }}">{{ env('IMAGE_WATERMARKER_WRITE') }}</a>

                            <!-- Available statuses: online, idle, busy, away and offline -->
                            <span class="profile-status online"></span>
                        </h3>

                        <p class="profile-title">Admin panel</p>

                    </div>

                </div>
                <!-- USER INFO - END -->



                <ul class='wraplist'>

                    <li class="@yield('menu_dashboard')">
                        <a href="{{ route('dashboard') }}">
                            <i class="fa fa-dashboard"></i>
                            <span class="title">Ana səhifə</span>
                        </a>
                    </li>


                    @if (
                        (auth()->check() &&
                            !empty(auth()->user()) &&
                            auth()->user()->can('category'))
                    )
                        <li class="@yield('menu_media')">
                            <a href="javascript:;">
                                <i class="fa fa-photo"></i>
                                <span class="title">Media</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                @if (auth()->check() &&
                                        !empty(auth()->user()) &&
                                        auth()->user()->can('category'))
                                    <li>
                                        <a class="" href="{{ route('category.index') }}">Kateqoriya</a>
                                    </li>
                                @endif

                                @if (auth()->check() &&
                                        !empty(auth()->user()) &&
                                        auth()->user()->can('sliders'))
                                    <li>
                                        <a class="" href="{{ route('sliders.index') }}">Slayder</a>
                                    </li>
                                @endif

                                @if (auth()->check() &&
                                        !empty(auth()->user()) &&
                                        auth()->user()->can('background_images'))
                                    <li>
                                        <a class="" href="{{ route('background_images.index') }}">Arxafon şəkilləri</a>
                                    </li>
                                @endif
                               
                            </ul>
                        </li>
                    @endif
                    @if (auth()->check() &&
                            !empty(auth()->user()) &&
                            auth()->user()->can('products'))
                        <li class="@yield('menu_products')">
                            <a href="javascript:;">
                                <i class="fa fa-file"></i>
                                <span class="title">Xidmətlar</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">

                                <li>
                                    <a class=""
                                        href="{{ route('products.index', ['status' => 'active']) }}">Aktiv
                                        Xidmətlar</a>
                                </li>


                            </ul>
                        </li>
                    @endif


                    @if (
                        (auth()->check() &&
                            !empty(auth()->user()) &&
                            auth()->user()->can('attributes')))
                        <li class="@yield('menu_products_elements')">
                            <a href="javascript:;">
                                <i class="fa fa-search"></i>
                                <span class="title">Xidmət elementləri</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                @if (auth()->check() &&
                                        !empty(auth()->user()) &&
                                        auth()->user()->can('attributes'))
                                    <li>
                                        <a class="" href="{{ route('attributes.index') }}">Attributlar</a>
                                    </li>
                                @endif

                                @if (auth()->check() &&
                                        !empty(auth()->user()) &&
                                        auth()->user()->can('comments'))
                                    <li>
                                        <a class="" href="{{ route('comments.index') }}">Şərhlər</a>
                                    </li>
                                @endif
                                

                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('Admin') ||
                            (auth()->check() &&
                                !empty(auth()->user()) &&
                                auth()->user()->can('payments')))
                        <li class="@yield('menu_payments')">
                            <a href="{{ route('payments.index') }}">
                                <i class="fa fa-credit-card"></i>
                                <span class="title">Ödənişlər</span>
                            </a>
                        </li>
                    @endif


                    @if ((auth()->check() &&
                                !empty(auth()->user()) &&
                                auth()->user()->can('orders')))
                        <li class="@yield('menu_orders')">
                            <a href="{{ route('orders.index') }}">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="title">Sifarişlər</span>
                            </a>
                        </li>
                    @endif


                    @if (
                        (auth()->check() &&
                            !empty(auth()->user()) &&
                            auth()->user()->can('standartpages')) ||
                            (auth()->check() &&
                                !empty(auth()->user()) &&
                                auth()->user()->can('settings')))
                        <li class="@yield('menu_website')">
                            <a href="javascript:;">
                                <i class="fa fa-windows"></i>
                                <span class="title">Sayt</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                @if (auth()->check() &&
                                        !empty(auth()->user()) &&
                                        auth()->user()->can('standartpages'))
                                    <li>
                                        <a class="" href="{{ route('standartpages.index') }}">Standart
                                            Səhifələr</a>
                                    </li>
                                @endif

                                @if (auth()->check() &&
                                        !empty(auth()->user()) &&
                                        auth()->user()->can('contactus'))
                                    <li>
                                        <a class="" href="{{ route('contactus.index') }}">Bizimlə əlaqə</a>
                                    </li>
                                @endif

                                @if (auth()->check() &&
                                        !empty(auth()->user()) &&
                                        auth()->user()->can('settings'))
                                    <li>
                                        <a class="" href="{{ route('settings.index') }}">Parametrlər</a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                    @endif

                    @if (auth()->check() &&
                            !empty(auth()->user()) &&
                            auth()->user()->can('users'))
                        <li class="@yield('menu_users')">
                            <a href="javascript:;">
                                <i class="fa fa-user"></i>
                                <span class="title">İstifadəçilər</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">

                                <li>
                                    <a class="" href="{{ route('users.index', ['type' => 'normal']) }}">Adi
                                        istifadəçilər</a>
                                </li>
                                <li>
                                    <a class=""
                                        href="{{ route('users.index', ['type' => 'company']) }}">Şirkətlər</a>
                                </li>
                               
                            </ul>
                        </li>
                    @endif

                    @if (
                        (auth()->check() &&
                            !empty(auth()->user()) &&
                            auth()->user()->can('admins')) ||
                            (auth()->check() &&
                                !empty(auth()->user()) &&
                                auth()->user()->can('permissions')))
                        <li class="@yield('menu_admins')">
                            <a href="javascript:;">
                                <i class="fa fa-cog"></i>
                                <span class="title">Adminstrativ</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">

                                @if (auth()->check() &&
                                        !empty(auth()->user()) &&
                                        auth()->user()->can('admins'))
                                    <li>
                                        <a class="" href="{{ route('admins.index') }}">Adminlər</a>
                                    </li>
                                @endif

                                @if (auth()->check() &&
                                        !empty(auth()->user()) &&
                                        auth()->user()->can('permissions'))
                                    <li>
                                        <a class="" href="{{ route('permissions.index') }}">İcazələr</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif


                </ul>

            </div>
            <!-- MAIN MENU - END -->


        </div>
        <!--  SIDEBAR - END -->
        @yield('content')

        <div class="chatapi-windows ">


        </div>
    </div>
    <!-- END CONTAINER -->

    <!-- CORE JS FRAMEWORK - START -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
    @yield('javascript')


    <script src="{{ asset('assets/js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}" type="text/javascript"></script>
    <!-- CORE JS FRAMEWORK - END -->

    <script>
        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>


    <script src="{{ asset('assets/js/scripts.js') }}" type="text/javascript"></script>

    {{-- <script src="{{ asset("build/assets/app-d516f91d.js") }}" type="module"></script> --}}
    {{-- @vite("resources/js/app.js") --}}
</body>


</html>
