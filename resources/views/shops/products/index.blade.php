@extends('layouts.app')
@section('menu_products', 'open')
@section('title')
@lang("additional.urls.services")
@endsection

@section('css')
    <meta name="_token" content="{{ csrf_token() }}">

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.24/r-2.2.7/rr-1.2.7/datatables.min.css" />

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->
    <!-- Switch -->
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #4bb543;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #4bb543;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        #cancel_reason_input {
            display: none;
        }
    </style>
    <!-- Switch -->
@endsection

@section('javascript')
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.24/r-2.2.7/rr-1.2.7/datatables.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>


    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#example').DataTable({
                    responsive: true,
                    "ordering": false,
                    "info": true,
                    "scrollCollapse": true,
                });
            }, 500);
        });

    </script>
   
@endsection

@section('content')
    @csrf
   
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">
                            @lang("additional.urls.services")
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'products',
                                    'harddelete' => false,
                                    'add' => true,
                                    'home' => false,
                                    'restoreall' => false,
                                ])</span>
                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang("additional.urls.dashboard")</a>
                            </li>
                            <li>
                                <a href="{{ route('products.index') }}">@lang("additional.urls.services")</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">@lang("additional.page_types.all") @lang("additional.urls.services")</h2>
                        <div class="actions panel_actions pull-right">
                            <i class="box_toggle fa fa-chevron-down"></i>
                            <i class="box_close fa fa-times"></i>
                        </div>
                    </header>
                    <div class="content-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <!-- ********************************************** -->
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>@lang("additional.forms.image")</th>
                                            <th>@lang("additional.forms.name")</th>
                                            <th>@lang("additional.forms.code")</th>
                                            <th>@lang("additional.forms.ammount")</th>
                                            <th>@lang("additional.urls.category")</th>
                                            <th>@lang("additioanl.urls.freelancer")</th>
                                            <th>@lang("additional.forms.viewcount")</th>
                                            <th>@lang("additional.buttons.buttons")</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $dat)
                                            <tr>
                                                @if (isset($dat->images) && !empty($dat->images) && isset($dat->images->first()->original_images))
                                                    <td>
                                                        <img width="125"
                                                        src="{{ asset("uploads/products/".$dat->images->first()->original_images) }}">
                                                    </td>
                                                @endif

                                                <td>{{ $dat->name['az_name'] ?? null }}</td>

                                                <td>{{ $dat->code }}</td>

                                                <td>
                                                    € {{ isset($dat->price) ? $dat->price : null }}
                                                <td>
                                                    @if ($dat->category_id != null)
                                                        <a
                                                            href="{{ url()->current() }}?status={{ $status ?? 'all' }}&category_id={{ $dat->category_id }} ">
                                                            <span class="text-info">
                                                                {{ $dat->category->name['az_name'] }}</span></a>
                                                    @else
                                                        <span class="text-danger">@lang("additional.forms.notfound")</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($dat->user_id != null)
                                                        <a
                                                            href="{{ url()->current() }}?status={{ $status ?? 'all' }}&user_id={{ $dat->user_id }} ">
                                                            <span class="text-info">
                                                                {{ $dat->user->name_surname ?? trans("additional.forms.notregistered_freelancer") }}
                                                                {{ $dat->user->phone ?? null }}</span></a>
                                                    @else
                                                        <span class="text-danger">@lang("additional.forms.notregistered_freelancer")</span>
                                                    @endif
                                                </td>
                                                <td>{{ count($dat->viewcount) }}</td>
                                                </td>
                                                <td>
                                                    <span>@include('layouts.buttons', [
                                                        'data' => $dat,
                                                        'routename' => 'products',
                                                        'view' => false,
                                                        'edit' => true,
                                                        'destroy' => true,
                                                        "harddelete"=>false,
                                                        "recover"=>false
                                                    ])

                                                    </span>

                                                </td>
                                            </tr>
                                            {{-- @endif --}}
                                        @endforeach
                                    </tbody>

                                </table>
                                <!-- ********************************************** -->

                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </section>
    </section>
    <!-- END CONTENT -->

@endsection
