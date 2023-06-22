@extends('layouts.app')
@section('menu_admins', 'open')
@section('title', 'Adminlər')

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
                        <h1 class="title">Adminlər
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons',['routename'=>'admins','harddelete'=>false,'add'=>true,'home'=>false,'restoreall'=>false])</span>
                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
                            </li>
                            <li>
                                <a href="{{ route('admins.index') }}">Adminlər</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">Bütün Adminlər</h2>
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
                                            <th>Düymələr</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $dat)
                                            <tr>
                                                <td>{{ $dat->name }}</td>
                                                <td>{{ $dat->email }}</td>
                                                <td>@include('layouts.buttons',["data"=>$dat,'routename'=>'admins','view'=>false,'edit'=>true,'destroy'=>true,'harddelete'=>false,'recover'=>false])
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