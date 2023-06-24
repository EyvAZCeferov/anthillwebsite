@extends('layouts.app')
@section('menu_orders', 'open')
@section('title', trans('additional.urls.orders'))

@section('css')
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.24/r-2.2.7/rr-1.2.7/datatables.min.css" />

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->
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
@endsection

@section('content')
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">@lang('additional.urls.orders')
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'orders',
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
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang('additional.urls.dashboard')</a>
                            </li>
                            <li>
                                <a href="{{ route('orders.index') }}">@lang('additional.urls.orders')</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">@lang('additional.page_types.all') @lang('additional.urls.orders')</h2>
                        <div class="actions panel_actions pull-right">
                            <i class="box_toggle fa fa-chevron-down"></i>
                            <i class="box_close fa fa-times"></i>
                        </div>
                    </header>
                    <div class="content-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <!-- ********************************************** -->
                                <table id="example" class="display table table-hover table-condensed dataTable no-footer"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Uid</th>
                                            <th>@lang('additional.urls.freelancer')</th>
                                            <th>@lang('additional.urls.user')</th>
                                            <th>@lang('additional.urls.service')</th>
                                            <th>@lang('additional.forms.ammount')</th>
                                            <th>@lang('additional.forms.date')</th>
                                            <th>@lang('additional.forms.status')</th>
                                            <th>@lang('additional.buttons.buttons')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $dat)
                                            <tr>
                                                <td>{{ $dat->uid }}</td>

                                                <td>
                                                    @if (isset($dat->to_id) && !empty($dat->to_id))
                                                        {{ users($dat->from_id, 'id')->name_surname }}-
                                                        {{ users($dat->from_id, 'id')->email }}
                                                    @else
                                                        <span class="text-danger">@lang('additional.forms.notregistered_freelancer')</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($dat->to_id) && !empty($dat->to_id))
                                                        {{ users($dat->to_id, 'id')->name_surname }} --
                                                        {{ users($dat->to_id, 'id')->email }}
                                                    @else
                                                        <span class="text-danger">@lang('additional.forms.notregistered_freelancer')</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($dat->product_id) && !empty($dat->product_id))
                                                        {{ products($dat->product_id, false)[0]->name['az_name'] }}
                                                    @else
                                                        <p class="text-center text-danger">@lang('additional.urls.service')
                                                            @lang('additional.forms.notfound')</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $dat->price }}€
                                                </td>

                                                <td>
                                                    {{ $dat->created_at }}
                                                </td>

                                                <td class="text-center p-2">
                                                    @if ($dat->status == 0)
                                                        <span class=" w-100 h-100 text-danger p-2">@lang('additional.order_statuese.statu_0')</span>
                                                    @elseif($dat->status == 1)
                                                        <span class=" w-100 h-100 text-info p-2">@lang('additional.order_statuese.statu_1')</span>
                                                    @elseif($dat->status == 2)
                                                        <span
                                                            class=" w-100 h-100 text-warning p-2">@lang('additional.order_statuese.statu_2')</span>
                                                    @elseif($dat->status == 3)
                                                        <span class=" w-100 h-100 text-dark p-2">@lang('additional.order_statuese.statu_3')</span>
                                                    @endif
                                                </td>

                                                <td>@include('layouts.buttons', [
                                                    'data' => $dat,
                                                    'routename' => 'orders',
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
