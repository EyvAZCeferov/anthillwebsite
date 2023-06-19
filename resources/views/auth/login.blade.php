<!DOCTYPE html>
<html class=" ">

<!-- Mirrored from jaybabani.com/ultra-admin-html/preview/ui-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 28 Oct 2021 18:53:12 GMT -->

<head>
    <!--
         * @Package: Ultra Admin - Responsive Theme
         * @Subpackage: Bootstrap
         * @Version: 4.1
         * This file is part of Ultra Admin Theme.
        -->
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Daxil ol</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <<meta content="EyvAZCeferov" name="author" />

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" /> <!-- Favicon -->
    <!-- CORE CSS FRAMEWORK - START -->
    <link href="{{ asset('assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css"
        media="screen" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet"
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

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="login_page" style="background-image:url('{{ asset('assets/images/login-bg.png') }}')">

    <div class="login-wrapper">
        <div id="login"
            class="login loginpage col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-0 col-xs-12">
            <h1><a href="{{env("APP_URL")}}" title="Login Page" tabindex="-1"
            style="background-image:none"
            >{{env("APP_NAME")}}</a></h1>

            <form action="{{ route('auth') }}" method="post">
                @csrf
                <p>
                    <label for="user_login">E-mail<br />
                        <input type="text" name="email" id="user_login" class="input" size="20" value="{{ old('email') }}"/>
                    </label>
                </p>
                <p>
                    <label for="user_pass">Password<br />
                        <input type="password" name="password" id="user_pass" class="input" size="20" /></label>
                </p>

                <p class="submit">
                    <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-orange btn-block"
                        value="Daxil ol" />
                </p>
            </form>

        </div>
    </div>

    <!-- CORE JS FRAMEWORK - START -->
    <script src="{{ asset('assets/js/jquery-1.11.2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>

    <!-- CORE JS FRAMEWORK - END -->

    <!-- CORE TEMPLATE JS - START -->
    <script src="{{ asset('assets/js/scripts.js') }}" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS - END -->

    <script>
        @if (Session::has('message'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>

</html>
