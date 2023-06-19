@extends('layouts.app')
@section('menu_orders', 'open')
@section('title')
    {{ $data->uid }}
@endsection

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
                        <h1 class="title">{{ $data->uid }}
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'orders',
                                    'harddelete' => false,
                                    'add' => false,
                                    'home' => true,
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
                                <a href="{{ route('orders.index') }}">Sifarişlər</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">Məlumatlar</h2>
                        <div class="actions panel_actions pull-right">
                            <i class="box_toggle fa fa-chevron-down"></i>
                            <i class="box_close fa fa-times"></i>
                        </div>
                    </header>
                    <div class="content-body">
                        <div class="row">
                            <!-- ********************************************** -->
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                Uid: {{ $data->uid }}
                            </div>

                            <div class="col-sm-4" style="margin-bottom: 1em">
                                Şirkət: {{ users($data->from_id, 'id')->name_surname }}
                                {{ users($data->from_id, 'id')->email }}
                                {{ users($data->from_id, 'id')->phone }}
                            </div>
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                İstifadəçi: {{ users($data->to_id, 'id')->name_surname }}
                                {{ users($data->to_id, 'id')->email }}
                                {{ users($data->to_id, 'id')->phone }}
                            </div>

                            <!-- ********************************************** -->
                            <br>
                            <br>
                            <!-- ********************************************** -->
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                Status: @if ($data->status == 0)
                                    <span class="bg-danger p-2">Sifariş qeydə alındı</span>
                                @elseif($data->status == 1)
                                    <span class="bg-info p-2">Sifariş qəbul olundu</span>
                                @elseif($data->status == 2)
                                    <span class="bg-warning p-2">Sifariş icra edilir</span>
                                @elseif($data->status == 3)
                                    <span class="bg-dark p-2">Sifariş tamamlandı</span>
                                @endif
                            </div>
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                Məbləğ: {{ $data->price }}€
                            </div>
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                İp address: {{ $data->ipaddress }}
                            </div>


                            <!-- ********************************************** -->
                        </div>
                        <br>
                        <div class="row">
                            <h2>Ödəniş</h2>
                        </div>
                        <div class="row">
                            <p>Tranzaksiya idsi: {{ payments($data->payment_id, 'id')->transaction_id }}</p>
                        </div>
                        <br />

                        <div class="row">
                            <h2>Məhsul</h2>
                        </div>
                        <div class="row">
                            <p>Məhsul adı: {{ products($data->product_id, 'id')[0]->name['az_name'] }}</p>
                        </div>
                        <br />
                        <h2>Sifariş statusu</h2>

                        <div class="row">
                            <form action="{{ route('order.changestat', $data->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="col-sm-6">
                                    <select name="status" class="form-control">
                                        <option value="0" @if ($data->status == 0) selected @endif>
                                            Sifariş qeydə alındı
                                        </option>
                                        <option value="1" @if ($data->status == 1) selected @endif>Sifariş
                                            qəbul olundu</option>
                                        <option value="2" @if ($data->status == 2) selected @endif>Sifariş
                                            icra edilir
                                        </option>
                                        <option value="3" @if ($data->status == 3) selected @endif>Sifariş
                                            tamamlandı
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-info">Təsdiqlə</button>
                                </div>
                            </form>
                        </div>

                        <br>
                        <h2>Məbləği geri qaytar</h2>

                        <div class="row">
                            <form action="{{ route('order.refund', $data->id) }}" method="post">
                                @csrf
                                <div class="col-sm-6">
                                    <input type="text" name="price" class="form-control" value="{{ $data->price }}" >
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-info">Təsdiqlə</button>
                                </div>
                            </form>
                        </div>

                        <!-- ********************************************** -->
                    </div>
            </div>
        </section>
        </div>

    </section>
    </section>
    <!-- END CONTENT -->

@endsection
