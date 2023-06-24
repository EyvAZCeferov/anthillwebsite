@extends('layouts.app')
@section('menu_dashboard', 'open')
@section('content')


    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">@lang("additional.urls.dashboard")</h1>
                    </div>


                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">

                    {{-- <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="r4_counter db_box">
                            <i class="pull-left fa fa-newspaper-o icon-md icon-rounded icon-primary"></i>
                            <div class="stats">
                                <h4><strong>{{ $posts }}</strong></h4>
                                <span>Xəbərlərə baxış</span>
                                <br>
                                <a href="{{ route('posts.index') }}">Ətraflı
                                </a>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="r4_counter db_box">
                            <i class="pull-left fa fa-envelope icon-md icon-rounded icon-orange"></i>
                            <div class="stats">
                                <h4><strong>{{ $contacts }}</strong></h4>
                                <span>Məktub yazanlar</span>
                                <br>
                                <a href="{{ route('contactus.index') }}">Ətraflı
                                </a>
                            </div>
                        </div>
                    </div> --}}



                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="r4_counter db_box">
                            <i class="pull-left fa fa-users icon-md icon-rounded icon-black"></i>
                            <div class="stats">
                                <h4><strong>{{ count(users()->where('is_admin',false)) }}</strong></h4>
                                <span>@lang("additional.urls.users")</span>
                                <br>
                                <a href="{{ route('users.index') }}">Ətraflı
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="r4_counter db_box">
                            <i class="pull-left fa fa-folder icon-md icon-rounded icon-danger"></i>
                            <div class="stats">
                                <h4><strong>{{ count(products()) }}</strong></h4>
                                <span>@lang("additional.urls.services")</span>
                                <br>
                                <a href="{{ route('products.index',['status'=>'published']) }}">Ətraflı
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="clearfix"></div>




        </section>
    </section>
    <!-- END CONTENT -->


@endsection
