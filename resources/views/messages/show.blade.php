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
                                Id: {{ $data->uid }}
                            </div>
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                Ödəniş tipi: @if ($data->type == 1)
                                    Bank Kartı vasitəsilə
                                @elseif($data->type == 2)
                                    Qapıda nağd ödəmə
                                @endif
                            </div>
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                İstifadəçi: {{ $data->user->name }} {{ $data->user->surname }} {{ $data->user->email }}
                                {{ $data->user->phone }}
                            </div>
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                Kupon kod: @if (isset($data->coupon_id) && $data->coupon_id != null)
                                    {{ $data->coupon->name['az_name'] }} - {{ $data->coupon->code }} -
                                    {{ $data->coupon->value }}{{ $data->coupon->type == 1 ? '%' : 'AZN' }}
                                @endif
                            </div>
                            <!-- ********************************************** -->
                            <br>
                            <br>
                            <!-- ********************************************** -->
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                Status: @if ($data->status == 0)
                                    <span class="bg-danger">Tamamlanmamış</span>
                                @elseif($data->status == 1)
                                    <span class="bg-info">Tamamlanmamış</span>
                                @elseif($data->status == 2)
                                    <span class="bg-warning">Yeni</span>
                                @elseif($data->status == 3)
                                    <span class="bg-dark">Kuryerdə</span>
                                @elseif($data->status == 4)
                                    <span class="bg-success">Tamamlanmış</span>
                                @endif
                            </div>
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                Məbləğ: @if (isset($data->action_price) && $data->action_price != 0)
                                    {{ $data->action_price }}€ <del style="font-size: 0.8em">{{ $data->price }}€</del>
                                @else
                                    {{ $data->price }}€
                                @endif
                            </div>
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                Məhsul sayı: {{ $data->qyt }}
                            </div>
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                İp address: {{ $data->ipaddress }}
                            </div>
                            <div class="col-sm-4" style="margin-bottom: 1em">
                                Sifariş qeydi: {{ $data->ordernote }}
                            </div>

                            <div class="col-sm-12" style="margin-bottom: 1em;margin-top:1.5em">
                                <span class="font-weight-bold"> Çatdırılma ünvan: </span><br />
                                <span style="font-weight: bold"> &nbsp; Ad Soyad :
                                </span>{{ $data->deliveryaddress->receiver_name }}
                                {{ $data->deliveryaddress->receiver_surname }}
                                <span style="font-weight: bold"> &nbsp; E-mail: </span>
                                {{ $data->deliveryaddress->receiver_email }}
                                <span style="font-weight: bold"> &nbsp; Phone: </span>
                                {{ $data->deliveryaddress->receiver_phone }}
                                <span style="font-weight: bold"> &nbsp; Adres: </span>
                                {{ $data->deliveryaddress->receiver_country }}
                                {{ $data->deliveryaddress->receiver_city }}
                                {{ $data->deliveryaddress->receiver_address }}
                                <span style="font-weight: bold"> &nbsp; Şirkət :</span>
                                {{ $data->deliveryaddress->receiver_company_address }}
                                {{ $data->deliveryaddress->receiver_company_voen }}
                            </div>

                            <div class="col-sm-4" style="margin-bottom: 1em">
                                Kuryer: {{ $data->courier_price }}€
                            </div>

                            <!-- ********************************************** -->
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <!-- ********************************************** -->
                            <h3>Məhsullar</h3>
                            <table class="table table-responsive">
                                <thead>
                                    <th>
                                        Şəkil
                                    </th>
                                    <th>
                                        Ad
                                    </th>
                                    <th>
                                        Məbləğ
                                    </th>
                                    <th>
                                        Say
                                    </th>
                                    <th>
                                        Sil
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($data->order_products as $product)
                                        <tr>
                                            @php
                                                $jsonDecodeName = json_decode($product->name, true);
                                            @endphp
                                            <td><img width="60" src="{{ $product->image }}"
                                                    alt="{{ $jsonDecodeName['az_name'] }}">
                                            </td>

                                            <td>{{ $jsonDecodeName['az_name'] }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->qyt }}</td>
                                            <td>
                                                <form action="{{ route('orderproducts.destroy', $product->id) }}"
                                                    method="post" style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="fa fa-remove"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- ********************************************** -->
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <form action="{{ route('order.changestat', $data->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="col-sm-6">
                                    <select name="status" class="form-control">
                                        <option value="0" @if ($data->status == 0) selected @endif>
                                            Tamamlanmamış
                                        </option>
                                        <option value="1" @if ($data->status == 1) selected @endif>Ödəniş
                                            gözləyir</option>
                                        <option value="2" @if ($data->status == 2) selected @endif>Hazırlanır
                                        </option>
                                        <option value="3" @if ($data->status == 3) selected @endif>Kuryerdə
                                        </option>
                                        <option value="4" @if ($data->status == 4) selected @endif>Tamamlandı
                                        </option>
                                    </select>
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
