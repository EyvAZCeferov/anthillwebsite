@extends('layouts.app')
@section('menu_payments', 'open')
@section('title')
    @lang("additional.urls.payments")
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
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->
    {{-- Change Stat --}}
    <script>
        function changeStat(id, status) {
            var token = $("meta[name='_token']").attr('content');

            var url = '{{ env('APP_URL ') }}/payments_change_stat/' + id;
            $.ajax({
                url: `${url}`,
                dataType: 'json',
                data: {
                    status: status,
                    _token: token
                },
                type: 'patch',
                success: function(data) {
                    toastr.success("@lang('additional.messages.updated')");
                },
                error: function(data) {
                    toastr.error(trans("additional.messages.tryagain"));
                }
            })
        }
    </script>
    {{-- Change Stat --}}
@endsection

@section('content')
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">@lang("additional.urls.payments")
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'payments',
                                    'harddelete' => false,
                                    'add' => false,
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
                                <a href="{{ route('payments.index') }}">@lang("additional.urls.payments")</a>
                            </li>

                        </ol>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="r4_counter db_box">
                            <i class="pull-left fa fa-cash icon-md icon-rounded icon-orange"></i>
                            <div class="stats">
                                <h4><strong>{{ App\Models\Payments::sum('amount') }}€</strong></h4>
                                <span>@lang("additional.general.general_ammount")</span>
                                <br>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="r4_counter db_box">
                            <i class="pull-left fa fa-cash icon-md icon-rounded icon-orange"></i>
                            <div class="stats">
                                <h4><strong>{{ App\Models\Payments::whereDate('created_at', Carbon\Carbon::today())->sum('amount') }}€</strong>
                                </h4>
                                <span>@lang("additional.general.today_ammount")</span>
                                <br>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">@lang("additional.page_types.all") @lang("additional.urls.payments")</h2>
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
                                            <th>@lang("additional.forms.transaction_id")</th>
                                            <th>@lang("additional.forms.status")</th>
                                            <th>@lang("additional.forms.ammount")</th>
                                            <th>@lang("additional.urls.freelancer")</th>
                                            <th>@lang("additional.urls.user")</th>
                                            <th>@lang("additional.urls.service")</th>
                                            <th>@lang("additional.buttons.buttons")</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $dat)
                                            <tr>
                                                {{-- <td>{{ $dat->id }}</td> --}}
                                                <td>
                                                    <a href="{{ route('payments.show', $dat->id) }}">
                                                        {{ $dat->transaction_id }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($dat->payment_status == 0)
                                                        <span class="text-danger">@lang("additional.order_statuese.payed_0")</span>
                                                    @else
                                                        <span class="text-success">@lang("additional.order_statuese.payed_1")</span>
                                                    @endif
                                                </td>

                                                <td>{{ $dat->amount }}€</td>
                                                <td>
                                                    @if (!empty($dat->from_id))
                                                        <a href="{{ route('users.show', users($dat->from_id, 'id')) }}">{{ users($dat->from_id, 'id')->name_surname }}
                                                            -- {{ users($dat->from_id, 'id')->email }} --
                                                            {{ users($dat->from_id, 'id')->phone }}</a>
                                                    @else
                                                        <p class="text-center text-danger">@lang("additional.forms.notfound")</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($dat->to_id))
                                                        <a href="{{ route('users.show', users($dat->to_id, 'id')) }}"
                                                            {{ trans('_blank') }}>{{ users($dat->to_id, 'id')->name_surname }}
                                                            -- {{ users($dat->to_id, 'id')->email }} --
                                                            {{ users($dat->to_id, 'id')->phone }}</a>
                                                    @else
                                                        <p class="text-center text-danger">@lang("additional.forms.notregistered_user")</p>
                                                    @endif
                                                    </a>
                                                </td>
                                                <td>{{ isset($dat->data['name']['az_name']) && !empty($dat->data['name']) ? $dat->data['name']['az_name'] : null }}
                                                </td>

                                                <td>@include('layouts.buttons', [
                                                    'data' => $dat,
                                                    'routename' => 'payments',
                                                    'view' => true,
                                                    'edit' => false,
                                                    'destroy' => true,
                                                    'harddelete' => false,
                                                    'recover' => false,
                                                ])
                                                </td>

                                            </tr>
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
