@extends('layouts.app')
@section('menu_users', 'open')
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


                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang("additional.urls.dashboard")</a>
                            </li>
                            <li>
                                @if ($data->type == 1)
                                    <a href="{{ route('users.index', ['type' => 'normal']) }}">@lang("additional.urls.user")</a>
                                @elseif($data->type == 3)
                                    <a href="{{ route('users.index', ['type' => 'company']) }}">@lang("additional.urls.freelancer")</a>
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
                        <h2 class="title pull-left">@lang("additional.page_types.info")</h2>
                        <div class="actions panel_actions pull-right">
                            <i class="box_toggle fa fa-chevron-down"></i>
                            <i class="box_close fa fa-times"></i>
                        </div>
                    </header>
                    <div class="content-body">
                        <div class="row">
                            <!-- ********************************************** -->
                            <div class="col-sm-3">
                                @lang("additional.forms.name_surname"): {{ $data->name_surname }}
                            </div>

                            <div class="col-sm-3">
                                @lang("additional.forms.email"): {{ $data->email }}
                            </div>
                            @if ($data->hasRole('Admin'))
                                <div class="col-sm-3">
                                    @lang("additional.forms.password"): {{ $data->additionalinfo->original_pass??' ' }}
                                </div>
                            @endif
                            <!-- ********************************************** -->
                            <br>

                            @if ($data->type != 1)
                                <div class="col-sm-8">
                                    @lang("additional.urls.freelancer"): {{ $data->additionalinfo->company_name['az_name'] ?? null }} <br />
                                    @lang("additional.forms.description"):
                                    {{ App\Helpers\Helper::strip_tags_with_whitespace($data->additionalinfo->company_description['az_description']) ?? ' ' }}

                                </div>
                            @endif

                            @if (isset($data->additionalinfo->company_image) && !empty($data->additionalinfo->company_image))
                                <div class="col-sm-4">
                                    @lang("additional.forms.image"): <img
                                        src="{{asset('/uploads/users/' . $data->additionalinfo->company_image)  }}"
                                        height="40" class="img-fluid img-responsive"
                                        alt="{{ $data->additionalinfo->company_name['az_name'] ?? $data->name_surname }}"
                                        style="height: 40px">
                                </div>
                            @endif


                            <!-- ********************************************** -->
                        </div>
                        <br>

                        <br>
                        <div class="row">
                            <!-- ********************************************** -->
                            <h3>@lang("additional.urls.services")</h3>
                            <table class="table table-responsive">
                                <thead>
                                    <th>
                                        @lang("additional.forms.image")
                                    </th>

                                    <th>
                                        @lang("additional.forms.ammount")
                                    </th>

                                    <th>
                                        @lang("additional.forms.date")
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($data->products as $product)
                                        <tr>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}" target="_blank">
                                                    <img width="125"
                                                        src="{{ asset("uploads/products/".$product->images->first()->original_images) }}">
                                                </a>
                                            </td>

                                            <td>
                                                @if ($product->type == 2)
                                                    {{ $product->price }}€
                                                    {{ $product->attributes->where('attribute_group_id', 9)->first()->attribute->name['az_name'] }}
                                                @else
                                                    {{ $product->price }}€
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
