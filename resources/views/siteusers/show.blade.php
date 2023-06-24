@extends('layouts.app')
@section('menu_media', 'open')
@section('title', 'Sayt İstifadəçiləri')

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
                        <h1 class="title">Sayt İstifadəçiləri
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'siteusers',
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
                                <a href="{{ route('siteusers.index') }}">Sayt İstifadəçiləri</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <section class="box ">
                        <h3>İstifadəçi məlumatları</h3>
                        <br>
                        <p>
                            <span class="font-weight-bold">İp Address</span> <span>{{ $data->ipaddress }}</span>
                            <br>
                            <span class="font-weight-bold">Device Data</span> <span>{{ $data->devicedata }}</span>
                            <br>
                            <span class="font-weight-bold">Adres Data</span>
                            <br>
                        </p>
                        <br>
                        <p>
                            <span>Continent</span> - <span>{{ $data->address_data['continent'] }}</span>
                            <br>
                            <span>Country</span> - <span>{{ $data->address_data['country'] }}</span>
                            <br>
                            <span>City</span> - <span>{{ $data->address_data['city'] }}</span>
                            <br>
                            <span>Latitude</span> - <span>{{ $data->address_data['latitude'] }}</span>
                            <br>
                            <span>Longitude</span> - <span>{{ $data->address_data['longitude'] }}</span>
                            <br>
                            <span>On Map</span> - <span><iframe
                                    src="https://www.google.com/maps/embed/v1/view?key={{ env('GOOGLE_MAPS_API_KEY') }}&center={{ $data->address_data['latitude'] }},{{ $data->address_data['longitude'] }}&zoom=14&maptype=satellite"
                                    frameborder="0"></iframe></span>
                                    <br>
                            <span>Geo Url</span> - <span>{{ $data->address_data['geourl'] }}</span>
                            <br>
                        </p>

                        {{-- "continent"=>$geo['geoplugin_continentName'] ?? null,
            "country"=>$geo['geoplugin_countryName'] ?? null,
            "city"=>$geo["geoplugin_city"] ?? null,
            "latitude"=>$geo["geoplugin_latitude"],
            "longitude"=>$geo["geoplugin_longitude"],
            "geourl"=>"http://www.geoplugin.net/php.gp?ip=$ipaddress" --}}
                        </p>
                    </section>
                </div>
            </div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">Bütün Sayt İstifadəçiləri</h2>
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
                                            <th>İp Adres</th>
                                            <th>Əvvəlki Url</th>
                                            <th>Url</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data->urls as $dat)
                                            <tr>


                                                <td>{{ $dat->user->ipaddress }}</td>
                                                <td>{{ $dat->previous_url }}</td>
                                                <td>{{ $dat->url }}</td>
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
