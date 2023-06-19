@extends('layouts.app')
@section('menu_orders', 'open')
@section('title')
    {{ $data->name_surname }}
@endsection

@section('css')
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.24/r-2.2.7/rr-1.2.7/datatables.min.css" />

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->
    <style>
        #price_input {
            display: block;
        }

        #package_input {
            display: none;
        }

        #balanceactions {
            display: none;
        }
    </style>
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

    <script>
        function add_balance_modal() {
            $("div#addbalancemodal").modal('show');
        }

        function typeofactionbalance(type) {
            $("div.invoices_balance").css('display', 'none');
            $("div#balanceactions").css('display', 'block');
            $("#action_name").text();
            $("#submit_button_on_modal").css('display', 'block');
            if (type == "add") {
                $("#action_name").text("Balansa əlavə");
                $("input[name=action_type]").val(1);
            } else if (type == "remove") {
                $("#action_name").text("Balansdan silinmə");
                $("input[name=action_type]").val(2);
            }
        }
    </script>
    <script>
        $("select[name=balance_type]").on('change', function() {
            $("#price_input").css('display', 'none');
            $("#package_input").css('display', 'none');
            if (this.value == "main_balance") {
                $("#price_input").css('display', 'block');
            } else if (this.value == "package") {
                $("#package_input").css('display', 'block');
            } else if (this.value == "bonus") {
                $("#price_input").css('display', 'block');
            }
        });
    </script>
    <script>
        function submitNow() {
            var form_data = $("#form_messages");
            form_data.empty();
            var posting = $.ajax({
                url: '{{ route('user.addbalance') }}',
                dataType: 'json',
                data: $("#submit_balanceaction").serialize(),
                type: 'post',
                success: function(data) {
                    if (data.status == "error") {
                        form_data.append(`<div class="alert alert-danger w-100">${data.message}</div>`);
                    } else {
                        form_data.append(`<div class="alert alert-danger w-100">${data.message}</div>`);
                        window.location.href = "{{ url()->current() }}";
                    }

                },
                error: function(data) {
                    if (data.status == "error") {
                        form_data.append(`<div class="alert alert-danger w-100">${data.message}</div>`);
                    } else {
                        form_data.append(`<div class="alert alert-danger w-100">${data.message}</div>`);
                        window.location.href = "{{ url()->current() }}";
                    }
                }
            });
        }
    </script>
@endsection

@section('content')

    <div class="modal fade" id="addbalancemodal" tabindex="-1" role="dialog" aria-labelledby="addbalancemodal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">İstifadəçinin balans məlumatları</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="invoices_balance">
                        <div class="invoices_balance-wallet_container">
                            <div class="invoices_balance-i">
                                <div>
                                    <div class="invoices_balance-title">Şəxsi balans</div>
                                </div>
                                <div>
                                    <div class="invoices_balance-value">
                                        {{ App\Helpers\Helper::calculatebalance($data->balances) }} AZN</div>
                                    {{-- <button class="invoices_balance-pay" value="@lang('additional.buttons.pay')"
                                    onclick="open_personal_balance_increment()"
                                    type="button">@lang('additional.buttons.incresebalance')</button>
                                @include('layouts_.partials.modals.personal_balance_increment') --}}
                                    <div style="height: 50px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="invoices_balance-types_container">

                            <div class="invoices_balance-types">
                                <div class="invoices_balance-i">
                                    <div>
                                        <div class="invoices_balance-i-title">Əsas balans</div>
                                    </div>
                                    <div class="invoices_balance-value">
                                        {{ App\Helpers\Helper::calculatebalance($data->balances->where('type', 'main_balance')) }}
                                        AZN</div>
                                </div>
                                <div class="invoices_balance-i">
                                    <div>
                                        <div class="invoices_balance-i-title">Paket balans</div>

                                    </div>
                                    <div class="invoices_balance-value">
                                        {{ App\Helpers\Helper::calculatebalance($data->balances->where('type', 'package')) }}
                                        AZN /
                                        {{ App\Helpers\Helper::calculatebalance($data->balances->where('type', 'package', 'announcements')) }}
                                    </div>
                                </div>
                                <div class="invoices_balance-i">
                                    <div>
                                        <div class="invoices_balance-i-title">Hədiyyə balans</div>
                                    </div>
                                    <div class="invoices_balance-value">
                                        {{ App\Helpers\Helper::calculatebalance($data->balances->where('type', 'bonus')) }}
                                        AZN
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="balanceactions">
                        <div id="form_messages"></div>
                        <form action="" method="post" id="submit_balanceaction" onsubmit="submitNow();">
                            @csrf
                            <input type="hidden" name="action_type">
                            <input type="hidden" name="user_id" value="{{ $data->id }}">
                            <div class="row">
                                <h2 id="action_name"></h2>
                            </div>
                            <div class="row">

                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <select name="balance_type" class="form-control">
                                            <option value="main_balance">Əsas Balans</option>
                                            <option value="package">Paket</option>
                                            <option value="bonus">Hədiyyə</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4" id="price_input">
                                    <div class="form-group">
                                        <input type="text" name="money" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-8" id="package_input">
                                    <div class="form-group">
                                        <select name="package_id" class="form-control">
                                            @foreach ($packages as $package)
                                                <option value="{{ $package->id }}">
                                                    {{ $package->name[app()->getLocale() . '_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="row px-5">
                        <button class="btn btn-info" onclick="typeofactionbalance('add')"><i class="fa fa-plus-circle"></i>
                            Əlavə et</button>
                        <button class="btn btn-danger" onclick="typeofactionbalance('remove')"><i
                                class="fa fa-minus-circle"></i> Sil</button>
                    </div>
                </div>

                <div class="modal-footer ">
                    <button type="button" onclick="submitNow();" id="submit_button_on_modal" class="btn btn-primary "
                        style="display: none">Təsdiq et</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
                </div>
            </div>
        </div>
    </div>
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">{{ $data->name_surname }} - @if ($data->type == 3)
                                {{ $data->additionalinfo->company_name['az_name'] ?? null }}
                            @endif
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'users',
                                    'harddelete' => false,
                                    'add' => false,
                                    'home' => true,
                                    'restoreall' => false,
                                ])</span>

                            <button class="btn btn-danger" onclick="add_balance_modal()">
                                <i class="fas fa-wallet"></i> Balans əməliyyatı
                            </button>
                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
                            </li>
                            <li>
                                @if ($data->type == 1)
                                    <a href="{{ route('users.index', ['type' => 'normal']) }}">İstifadəçilər</a>
                                @elseif($data->type == 2)
                                    <a href="{{ route('users.index', ['type' => 'agency']) }}">Vasitəçi</a>
                                @elseif($data->type == 3)
                                    <a href="{{ route('users.index', ['type' => 'company']) }}">Şirkətlər</a>
                                @endif
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
                            <div class="col-sm-3">
                                Ad Soyad: {{ $data->name_surname }}
                            </div>

                            <div class="col-sm-3">
                                E-mail: {{ $data->email }}
                            </div>
                            <div class="col-sm-3">
                                Telefon: {{ $data->phone }}
                            </div>
                            <div class="col-sm-3">
                                Telefon 2: {{ $data->phone_2 }}
                            </div>
                            @if ($data->hasRole('Admin'))
                                <div class="col-sm-3">
                                    Şifrə: {{ $data->additionalinfo->original_pass }}
                                </div>
                            @endif
                            <!-- ********************************************** -->
                            <br>
                            <br>
                            <!-- ********************************************** -->
                            <div class="col-sm-3">
                                Status: @if ($data->verified == 1)
                                    <span class="bg-success text-white">Təsdiqlənmiş</span>
                                @else
                                    <span class="bg-danger text-white">Təsdiq edilməmiş</span>
                                @endif
                            </div>
                            @if ($data->type != 1)
                                <div class="col-sm-3">
                                    Şirkət: {{ $data->additionalinfo->company_name['az_name'] ?? null }} <br />
                                    Şirkət Adresi: {{ $data->additionalinfo->company_address['az_address'] ?? ' ' }}<br />
                                    Şirkət Haqqında:
                                    {{ $data->additionalinfo->company_description['az_description'] ?? ' ' }}
                                    <br />
                                    Şirkət İş saatları: {{ $data->additionalinfo->company_times['az_time'] ?? ' ' }} <br />
                                </div>
                            @endif

                            <div class="col-sm-3">
                                Profil şəkli: <img src="{{ $data->additionalinfo->company_image ?? null }}" height="40"
                                    class="img-fluid img-responsive"
                                    alt="{{ $data->additionalinfo->company_name['az_name'] ?? null }}" style="height: 40px">
                            </div>

                            <div class="col-sm-3">
                                Profil arxafon şəkli: <img src="{{ $data->additionalinfo->company_background_image ?? null }}"
                                    height="40" class="img-fluid img-responsive"
                                    alt="{{ $data->additionalinfo->company_name['az_name'] ?? null }}" style="height: 60px">
                            </div>

                            <!-- ********************************************** -->
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <!-- ********************************************** -->
                            <h3>Bildirişlər</h3>
                            <table class="table table-responsive">
                                <thead>
                                    <th>
                                        Kontent
                                    </th>
                                    <th>
                                        Zaman
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($data->notifications as $notification)
                                        <tr>
                                            <td>{{ $notification->value }}</td>
                                            <td>{{ $notification->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- ********************************************** -->
                        </div>

                        <br>
                        <div class="row">
                            <!-- ********************************************** -->
                            <h3>Balans əməliyyatları</h3>
                            <table class="table table-responsive">
                                <thead>
                                    <th>
                                      Ödənilən  Məbləğ
                                    </th>
                                    <th>
                                        Ödəniş tarixi
                                    </th>
                                    <th>
                                        Xidmət
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($data->balances as $balance)
                                        <tr>
                                            <td>
                                                @if ($balance->value > 0 && $balance->announcement == 0)
                                                {{ $balance->value }} AZN
                                            @elseif($balance->value > 0 && $balance->announcement > 0)
                                                {{ $balance->value }} AZN / {{ $balance->announcement }}
                                                @lang('additional.pages.profile.announcement')
                                            @elseif ($balance->value == 0 && $balance->announcement > 0)
                                                {{ $balance->announcement }} @lang('additional.pages.profile.announcement')
                                            @endif
                                            </td>
                                           <td>
                                               {{ $balance->created_at }}
                                           </td>
                                           <td>
                                               @if ($balance->data['for'] == 'package')
                                               @endif
                                           </td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                            <!-- ********************************************** -->
                        </div>
                        <br>
                        <div class="row">
                            <!-- ********************************************** -->
                            <h3>Elanlar</h3>
                            <table class="table table-responsive">
                                <thead>
                                    <th>
                                        Şəkli
                                    </th>
                                    <th>
                                        Adres
                                    </th>
                                    <th>
                                        Əlaqə məlumatları
                                    </th>
                                    <th>
                                        Qiymət
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Tipi
                                    </th>
                                    <th>
                                        Dərc Tarixi
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($data->products as $product)
                                    
                                        <tr>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}" target="_blank">
                                                 
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}">
                                                    {{ $product->address['az_address'] }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $product->contactinfo['username'] }} --
                                                {{ $product->contactinfo['phone'] }}
                                            </td>
                                            <td>
                                                @if ($product->type == 2)
                                                    {{ $product->price }}€
                                                    {{ $product->attributes->where('attribute_group_id', 9)->first()->attribute->name['az_name'] }}
                                                @else
                                                    {{ $product->price }}€
                                                @endif
                                            </td>
                                            <td>
                                                @if ($product->status == 0)
                                                    <span class="text-warning">Təsdiq gözləyir</span>
                                                @elseif($product->status == 1)
                                                    <span class="text-danger">Təsdiq edilməyib</span>
                                                @elseif($product->status == 2)
                                                    <span class="text-success">Təsdiq edilib</span>
                                                @elseif($product->status == 3)
                                                    <span class="text-info">Vaxtı keçib</span>
                                                @elseif($product->status == 4)
                                                    <span class="text-warning">Ödəniş gözləyir</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($product->share_type == 1)
                                                    <span class="text-info">Öz elanım</span>
                                                @elseif($product->share_type == 2)
                                                    <span class="text-dark">Vasitəçi / Şirkət</span>
                                                @endif
                                            </td>
                                            <td>{{ $product->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- ********************************************** -->
                        </div>
                    </div>
                </section>
            </div>

        </section>
    </section>
    <!-- END CONTENT -->

@endsection
