@extends('layouts.app')
@section('menu_website', 'open')
@section('title')
    @if (isset($data) && !empty($data))
        @lang('additional.urls.lang_properties') @lang('additional.page_types.update')
    @else
        @lang('additional.urls.lang_properties') @lang('additional.page_types.create')
    @endif
@endsection

@section('content')
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">
                            @if (isset($data) && !empty($data))
                                @lang('additional.urls.lang_properties') @lang('additional.page_types.update')
                            @else
                                @lang('additional.urls.lang_properties') @lang('additional.page_types.create')
                            @endif
                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang('additional.urls.dashboard')</a>
                            </li>
                            <li>
                                <a href="{{ route('lang_properties.index') }}">@lang('additional.urls.lang_properties')</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <div class="actions panel_actions pull-right">
                            <i class="box_toggle fa fa-chevron-down"></i>
                            <i class="box_close fa fa-times"></i>
                        </div>
                    </header>
                    <div class="content-body">

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <!-- ********************************************** -->
                                <form
                                    action="{{ isset($data) && !empty($data) ? route('lang_properties.update', $data->id) : route('lang_properties.store') }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @if (isset($data) && !empty($data))
                                        @method('PATCH')
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <input type="text" placeholder="@lang('additional.forms.name') ..." class="form-control"
                                                name="name"
                                                value="{{ !empty($data) && isset($data->name) ? $data->name : null }}">
                                            <br>
                                            <input type="text" @if(!empty($data) && isset($data->keyword)) disabled @endif placeholder="@lang('additional.forms.keyword') ..." class="form-control"
                                                name="keyword"
                                                value="{{ !empty($data) && isset($data->keyword) ? $data->keyword : null }}">
                                            <br>
                                            <input type="hidden" name="lang" value="en">
                                            <br>

                                        </div>
                                    </div>

                            </div>
                            <br>
                            

                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                    <div class="text-left">
                                        <button type="submit" class="btn btn-primary">@lang('additional.buttons.submit')</button>
                                        <a type="button" href="{{ route('lang_properties.index') }}"
                                            class="btn">@lang('additional.buttons.cancel')</a>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <!-- ********************************************** -->

                        </div>
                    </div>

                    <br>

            </div>
        </section>
        </div>

    </section>
    </section>
    <!-- END CONTENT -->

@endsection
