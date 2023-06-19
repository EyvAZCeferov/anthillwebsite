<!DOCTYPE html>
<html class=" ">

<!-- Mirrored from jaybabani.com/ultra-admin-html/preview/ui-lockscreen.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 28 Oct 2021 19:03:10 GMT -->

<head>
    <!--
         * @Package: ExpertSm - Responsive Theme
         * @Subpackage: Bootstrap
         * @Version: 4.1
         * This file is part of ExpertSm Theme.
        -->
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>{{env("APP_NAME")}} : Lockscreen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="EyvAZCeferov" name="author" />

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" /> <!-- Favicon -->
    <!-- CORE CSS FRAMEWORK - START -->
    <link href="{{ asset('assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css"
        media="screen" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet"
        type="text/css" />


    <!-- CORE CSS FRAMEWORK - START -->
    <link href="{{ asset('assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css"
        media="screen" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/fonts/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->


    <!-- CORE CSS TEMPLATE - START -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->


    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class=" ">

    <div class="col-lg-12">
        <section class="box nobox">
            <div class="content-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <h1 class="lockscreen_icon"><i class='fa fa-lock'></i></h1>
                        <h1 class="lockscreen_info">Salam
                            @auth
                                {{ auth()->user()->name }}
                            @endauth

                            </h1>

                        <div
                            class="col-md-4 col-sm-6 col-xs-8 col-md-offset-4 col-sm-offset-3 col-xs-offset-2 lockscreen_search_area">
                            <form action="{{ route("auth.verify") }}" method="post" class="lockscreen_search">
                                {{-- @csrf --}}
                                <input type="hidden" name="c" value="{{ $code }}">
                                <input type="hidden" name="e" value="{{ $email }}">
                                <input type="hidden" name="p" value="{{ $password }}">
                                <div class="input-group transparent">
                                    <span class="input-group-addon">
                                        <i class="fa fa-unlock icon-primary"></i>
                                    </span>
                                    <input type="text" class="form-control" name="code" placeholder="Type & Enter">
                                    <input type='submit' value="">
                                </div>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                        <h1 class="lockscreen_tagline">E-mail ə gələn şifrəni daxil et</h1>


                    </div>
                </div>
            </div>
        </section>
    </div>



    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->


    <!-- CORE JS FRAMEWORK - START -->
    <script src="assets/js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.easing.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script>
    <script src="assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>
    <!-- CORE JS FRAMEWORK - END -->


    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


    <!-- CORE TEMPLATE JS - START -->
    <script src="assets/js/scripts.js" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS - END -->

    <!-- Sidebar Graph - START -->
    <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
    <!-- Sidebar Graph - END -->

        <!-- CORE TEMPLATE JS - START -->
        <script src="{{ asset('assets/js/scripts.js') }}" type="text/javascript"></script>
        <!-- END CORE TEMPLATE JS - END -->

    <script>
        jQuery("form").submit(function(event){
            event.preventDefault()
            let code = jQuery(this).find("input[name='code']").val()
            let c = jQuery(this).find("input[name='c']").val()
            let e = jQuery(this).find("input[name='e']").val()
            let p = jQuery(this).find("input[name='p']").val()
            jQuery.ajax({
                url: '{{ route('auth.verify') }}',
                method: 'POST',
                data: {
                    c, e, p, code, "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data)
                    toastr.options =
                    {
                    "closeButton" : true,
                    "progressBar" : true
                    }
                    if(data.status == 'success'){
                        toastr.info(data.message);
                        window.location.href = "/"
                    }
                    else{
                        toastr.error(data.message);
                    }
                }
            });
        })
    </script>












    <!-- General section box modal start -->
    <div class="modal" id="section-settings" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label"
        aria-hidden="true">
        <div class="modal-dialog animated bounceInDown">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Section Settings</h4>
                </div>
                <div class="modal-body">

                    Body goes here...

                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button class="btn btn-success" type="button">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal end -->
</body>

<!-- Mirrored from jaybabani.com/ultra-admin-html/preview/ui-lockscreen.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 28 Oct 2021 19:03:10 GMT -->

</html>
