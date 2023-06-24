@extends('layouts.app')
@section('menu_admins', 'open')
@section('title')
    @if (isset($data) && !empty($data))
        @lang('additional.urls.permissions') @lang('additional.page_types.update')
    @else
        @lang('additional.urls.permissions') @lang('additional.page_types.create')
    @endif
@endsection
@section('content')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/flags/css/flag-icons.min.css') }}">
    <link href="{{ asset('assets/plugins/tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css"
        media="screen" />
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.24/r-2.2.7/rr-1.2.7/datatables.min.css" />
@endsection
@section('javascript')
    @include('layouts.seo.createseoscript')
    <script src="{{ asset('assets/plugins/tagsinput/js/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
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
@endsection

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper" style=''>

        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">

                <div class="pull-left">
                    <h1 class="title">
                        @if (isset($data) && !empty($data))
                            @lang('additional.urls.permissions') @lang('additional.page_types.update')
                        @else
                            @lang('additional.urls.permissions') @lang('additional.page_types.create')
                        @endif
                        &nbsp;&nbsp;
                        <span>
                            @include('layouts.topbarbuttons', [
                                'routename' => 'permissions',
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
                            <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang('additional.urls.dashboard')</a>
                        </li>
                        <li>
                            <a href="{{ route('permissions.index') }}">@lang('additional.urls.permissions')</a>
                        </li>

                    </ol>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>


        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <section class="box ">
                <header class="panel_header">
                    <div class="actions panel_actions pull-right">
                        <i class="box_toggle fa fa-chevron-down"></i>
                        <i class="box_close fa fa-times"></i>
                    </div>
                </header>
                <div class="content-body">
                    <div class="row">
                        <form
                            @if (isset($data) && !empty($data)) action="{{ route('permissions.update', $data->id) }}"  @else action="{{ route('permissions.store') }}" @endif
                            method="post" enctype="multipart/form-data">
                            @if (isset($data) && !empty($data))
                                @method('PUT')
                            @endif
                            @csrf

                            <div class="row">


                                <input type="text" placeholder="@lang('additional.forms.addnameswithindicator(,)')" class="form-control"
                                    name="names"
                                    value="{{ !empty($data) && isset($data->name) ? $data->name : null }}">
                                <br>
                            </div>
                            <br>


                            <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                <div class="text-left">
                                    <button type="submit" class="btn btn-primary">@lang('additional.buttons.submit')</button>
                                    <a type="button" href="{{ route('permissions.index') }}"
                                        class="btn">@lang('additional.buttons.cancel')</a>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </section>
        </div>

    </section>
</section>
<!-- END CONTENT -->

@endsection
