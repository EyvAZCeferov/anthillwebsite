@extends('layouts.app')
@section('menu_orders', 'open')
@section('title')
    @if ($type == 'normal')
        Normal İstifadəçilər
    @elseif($type == 'agency')
        Vasitəçilər
    @elseif($type == 'company')
        Şirkətlər
    @elseif($type == 'yasayiskompleksleri')
        Yaşayış kompleksləri
    @endif
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
                        <h1 class="title">
                            @if ($type == 'normal')
                                Normal İstifadəçilər
                            @elseif($type == 'agency')
                                Vasitəçilər
                            @elseif($type == 'company')
                                Şirkətlər
                            @elseif($type == 'yasayiskompleksleri')
                                Yaşayış kompleksləri
                            @endif
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'users',
                                    'harddelete' => true,
                                    'add' => true,
                                    'home' => false,
                                    'restoreall' => false,
                                ]) </span>
                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
                            </li>
                            <li>
                                <a href="{{ route('users.index') }}">İstifadəçilər</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">Bütün @if ($type == 'normal')
                                Normal İstifadəçilər
                            @elseif($type == 'agency')
                                Vasitəçilər
                            @elseif($type == 'company')
                                Şirkətlər
                            @elseif($type == 'yasayiskompleksleri')
                                Yaşayış kompleksləri
                            @endif
                        </h2>
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
                                            <th>Ad</th>
                                            <th>Email</th>
                                            <th>Telefon</th>
                                            <th>Təsdiqlənmə statusu</th>
                                            @if ($type != 'normal')
                                                <th>Şirkət</th>
                                                <th>Elanlar</th>
                                            @endif
                                            <th>Düymələr</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $dat)
                                            <tr>
                                                <td>{{ $dat->name_surname }}</td>
                                                <td>{{ $dat->email }}</td>
                                                <td>{{ $dat->phone }}</td>
                                                <td>
                                                    @if ($dat->verified == true)
                                                        <span class="bg-success text-white">Təsdiqlənmiş</span>
                                                    @else
                                                        <span class="bg-danger text-white">Təsdiq edilməmiş</span>
                                                    @endif
                                                </td>

                                                @if ($type != 'normal')
                                                    <td>{{ $dat->additionalinfo->company_name['az_name'] ?? null }}</td>
                                                    <td>{{ count($dat->products) }}</td>
                                                @endif
                                                <td>@include('layouts.buttons', [
                                                    'data' => $dat,
                                                    'routename' => 'users',
                                                    'view' => true,
                                                    'edit' => true,
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
