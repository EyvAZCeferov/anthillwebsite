@extends('layouts.app')
@section('menu_website', 'open')
@section('title', $data->name . ' məktub')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/flags/css/flag-icons.min.css') }}">
@endsection

@section('content')
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">{{ $data->name }}
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons',['routename'=>'contactus','harddelete'=>false,'add'=>false,'home'=>true,'restoreall'=>false])
                            </span>
                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
                            </li>
                            <li>
                                <a href="{{ route('contactus.index') }}">Məktublər</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">Məktub məlumatları</h2>
                        <div class="actions panel_actions pull-right">
                            <i class="box_toggle fa fa-chevron-down"></i>
                            <i class="box_close fa fa-times"></i>
                        </div>
                    </header>
                    <div class="content-body">

                        <!-- ********************************************** -->

                        <div class="row">
                            <div class="col-sm-3">
                                <h3>Ad</h3>
                                <p>{{ $data->name }}</p>
                            </div>
                            <div class="col-sm-3">
                                <h3>E-Mail</h3>
                                <p><a
                                    href="mailto:{{ $data->email }}">{{ $data->email }}</a></p>
                            </div>
                            <div class="col-sm-3">
                                <h3>Phone</h3>
                                <p><a
                                    href="tel:{{ $data->phone }}">{{ $data->phone }}</a></p>
                            </div>
                            <div class="col-sm-3">
                                <h3>İpaddress</h3>
                                <p>{{ $data->ipadress }}</p>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="row">
                            {{ $data->message }}
                        </div>
                        <br>
                        <hr>
                        <br>
                        <!-- ********************************************** -->

                    </div>
                </section>
            </div>

        </section>
    </section>
    <!-- END CONTENT -->

@endsection
