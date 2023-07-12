@extends('layouts.app')
@section('menu_website', 'open')
@section('title')
    @if (isset($data) && !empty($data))
        @lang('additional.urls.standart_page') @lang('additional.page_types.update')
    @else
        @lang('additional.urls.standart_page') @lang('additional.page_types.create')
    @endif
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/flags/css/flag-icons.min.css') }}">
@endsection


@section('javascript')
    @include('layouts.ckeditor.ckeditorService', [
        'uploadUrl' => route('ckEditorUpload'),
        'editors' => ['en_description'],
    ])
    @include('layouts.seo.createseoscript')

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
                                @lang('additional.urls.standart_page') @lang('additional.page_types.update')
                            @else
                                @lang('additional.urls.standart_page') @lang('additional.page_types.create')
                            @endif
                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang('additional.urls.dashboard')</a>
                            </li>
                            <li>
                                <a href="{{ route('standartpages.index') }}">@lang('additional.urls.standart_pages')</a>
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
                                    action="{{ isset($data) && !empty($data) ? route('standartpages.update', $data->id) : route('standartpages.store') }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @if (isset($data) && !empty($data))
                                        @method('PATCH')
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <input type="text" placeholder="@lang("additional.forms.name") ..." class="form-control"
                                                name="en_name"
                                                value="{{ !empty($data) && isset($data->name['en_name']) ? $data->name['en_name'] : null }}">
                                            <br>
                                            <textarea class="form-control en_description" placeholder="@lang("additional.forms.description") ..." name="en_description"
                                                style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{!! isset($data) && !empty($data) && $data->description != null && isset($data->description['en_description'])
                                                    ? $data->description['en_description']
                                                    : null !!}</textarea>
                                            <br>

                                            @include('layouts.seo.createseo', [
                                                'langKey' => 'en',
                                                'data' => isset($data) && !empty($data) ? $data->seo : null,
                                            ])
                                            <br>

                                        </div>



                                    </div>

                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang("additional.forms.type")</label>
                                        <div class="controls">
                                            <select name="type" class="form-control">
                                                <option value="about" @if (!empty($data) && $data->type == 'about') selected @endif>
                                                    @lang("additional.page_names.aboutus")</option>
                                                <option value="termofuse" @if (!empty($data) && $data->type == 'termofuse') selected @endif>
                                                    @lang("additional.page_names.termofuse")</option>
                                                <option value="privarcypolicy"
                                                    @if (!empty($data) && $data->type == 'privarcypolicy') selected @endif>@lang("additional.page_names.privarcypolicy")
                                                </option>
                                                <option value="cancellationandrefundpolicy"
                                                    @if (!empty($data) && $data->type == 'cancellationandrefundpolicy') selected @endif>@lang("additional.page_names.refundpolicy")</option>
                                                <option value="homepage" @if (!empty($data) && $data->type == 'homepage') selected @endif>
                                                    @lang("additional.page_names.welcome")</option>
                                                <option value="services" @if (!empty($data) && $data->type == 'services') selected @endif>
                                                    @lang("additional.urls.services")</option>
                                                <option value="customers" @if (!empty($data) && $data->type == 'customers') selected @endif>
                                                    @lang("additional.urls.freelancers")</option>
                                                <option value="login" @if (!empty($data) && $data->type == 'login') selected @endif>
                                                    @lang("additional.urls.login")</option>
                                                <option value="register" @if (!empty($data) && $data->type == 'register') selected @endif>
                                                    @lang("additional.page_names.register")</option>
                                                <option value="wishlist"
                                                    @if (!empty($data) && $data->type == 'wishlist') selected @endif>@lang("additional.page_names.wishlist")</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang("additional.forms.image")</label>
                                        <br>
                                        <div class="row">
                                            @if (isset($data) && $data != null && $data->image != null)
                                                <div class="col-sm-12 col-md-3">
                                                    <img style="object-fit:contain;width:100%;"
                                                        src="{{ App\Helpers\Helper::getImageUrl($data->image, 'standartpages') }}">
                                                </div>
                                            @endif
                                        </div>
                                        <br>
                                        <div class="controls">
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                    <div class="text-left">
                                        <button type="submit" class="btn btn-primary">@lang('additional.buttons.submit')</button>
                                        <a type="button" href="{{ route('standartpages.index') }}" class="btn">@lang("additional.buttons.cancel")</a>
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
