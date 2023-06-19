@extends('layouts.app')
@section('menu_raports', 'open')
@section('title', 'Analistika')

@section('css')
    <meta name="_token" content="{{ csrf_token() }}">
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
                    "ordering": true,
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
                        <h1 class="title">Analistika {{ isset($title) && !empty($title) ? '-' . $title : null }}
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'raports',
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
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
                            </li>
                            <li>
                                <a href="{{ route('raports.index') }}">Analistika</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">Bütün Analistika</h2>
                        <div class="actions panel_actions pull-right">
                            <i class="box_toggle fa fa-chevron-down"></i>
                            <i class="box_close fa fa-times"></i>
                        </div>
                    </header>
                    <div class="content-body">
                        <div class="row">
                            <form action="{{ route('raports.index') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="coupon_id">Kupon</label>
                                        <select name="coupon_id" class="form-control" id="coupon_id">
                                            <option value="">Bir kupon seçin</option>
                                            @foreach ($couponcodes as $coupon)
                                                <option value="{{ $coupon->id }}"
                                                    @if (isset($parametr['coupon_id']) && !empty($parametr['coupon_id']) && $parametr['coupon_id'] == $coupon->id) selected @endif>
                                                    {{ $coupon->name['az_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="starttime">Başlanğıc vaxt</label>
                                        <input type="date" class="form-control" id="starttime" name="starttime"
                                            @if (isset($parametr['starttime']) && !empty($parametr['starttime'])) value="{{ $parametr['starttime'] }}" @endif>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="endtime">Bitmə vaxtı</label>
                                        <input type="date" class="form-control" name="endtime"
                                            @if (isset($parametr['endtime']) && !empty($parametr['endtime'])) value="{{ $parametr['endtime'] }}" @endif>
                                    </div>
                                    <div
                                        class="col-sm-2 align-items-center justify-content-center align-content-center align-center text-center">
                                        <button type="submit" class="btn btn-info"
                                            style="margin-bottom: 0.5em">Axtar</button>
                                        <br>
                                        <a href="{{ route('raports.index') }}" class="btn btn-danger">Təmizlə</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Sifarişlərin ümumi məbləği:
                                    <strong>€{{ $parametr['totalpricewithoutcoupon'] }}</strong>
                                </p>
                            </div>
                            <div class="col-sm-4">
                                <p>Kupon Kod İstifadəsindən sonrakı ümumi məbləğ:
                                    <strong>€{{ $parametr['totalpricewithcoupon'] }}</strong>
                                </p>
                            </div>
                            <div class="col-sm-4">
                                <p>Kuryerin ümumi məbləği:
                                    <strong>€{{ $parametr['totalcourierprice'] }}</strong>
                                </p>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <!-- ********************************************** -->
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sifariş Uİd</th>
                                            <th>Sifarişçi</th>
                                            <th>Sifarişin endirimsiz məbləği</th>
                                            <th>Ödənilmiş məbləğ</th>
                                            <th>Kuryerə ödənilmiş məbləğ</th>
                                            <th>Məhsul sayı</th>
                                            <th>Tarix</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $dat)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('orders.show', $dat->id) }}" target="_blank">
                                                        {{ $dat->uid }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('users.show', $dat->user->id) }}" target="_blank">
                                                        {{ $dat->user->name }} {{ $dat->user->surname }}
                                                    </a>
                                                </td>
                                                <td>€{{ $dat->price }}</td>
                                                <td>€{{ $dat->action_price }}</td>
                                                <td>€{{ $dat->courier_price }}</td>
                                                <td>{{ count($dat->order_products) }}</td>
                                                <td>{{ $dat->created_at }}</td>
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
