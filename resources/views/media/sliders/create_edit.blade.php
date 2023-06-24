@extends('layouts.app')
@section('menu_media', 'open')
@section('title')
    @if (isset($data) && !empty($data))
        @lang('additional.urls.slider') @lang('additional.page_types.update')
    @else
        @lang('additional.urls.slider') @lang('additional.page_types.create')
    @endif
@endsection
@section('content')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/flags/css/flag-icons.min.css') }}">
@endsection
@section('javascript')
    @include('layouts.ckeditor.ckeditorService', [
        'uploadUrl' => route('ckEditorUpload'),
        'editors' => ['en_description'],
    ])
@endsection

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper" style=''>

        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">

                <div class="pull-left">
                    <h1 class="title">
                        @if (isset($data) && !empty($data))
                            @lang('additional.urls.slider') @lang('additional.page_types.update')
                        @else
                            @lang('additional.urls.slider') @lang('additional.page_types.create')
                        @endif @lang('additional.page_types.create')
                        &nbsp;&nbsp;
                        <span>
                            @include('layouts.topbarbuttons', [
                                'routename' => 'sliders',
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
                            <a href="{{ route('sliders.index') }}">@lang('additional.urls.sliders')</a>
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
                            @if (isset($data) && !empty($data)) action="{{ route('sliders.update', $data->id) }}" @else action="{{ route('sliders.store') }}" @endif
                            method="post" enctype="multipart/form-data">
                            @csrf

                            @if (isset($data) && !empty($data))
                                @method('PUT')
                            @endif

                            <div class="row">

                                <br>

                                <textarea class="bootstrap-wysihtml5-textarea  en_description" placeholder="@lang('additional.forms.description') ..."
                                    name="en_description" style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{{ isset($data) && !empty($data) && isset($data->description['en_description']) ? $data->description['en_description'] : null }}</textarea>
                                <br>

                            </div>
                            <br>


                            <div class="row">


                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <label class="form-label">@lang('additional.forms.image')</label>
                                        @if (isset($data) && !empty($data) && !empty($data->image))
                                            <img width="125" src="{{ asset('/uploads/sliders/' . $data->image) }}">
                                        @endif
                                        <div class="controls">
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <label class="form-label">@lang('additional.forms.url')</label>
                                        <div class="controls">
                                            <input type="url" class="form-control" name="url"
                                                @if (isset($data) && !empty($data) && isset($data->url)) value="{{ $data->url }}" @endif>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <label class="form-label">@lang('additional.forms.order')</label>
                                        <div class="controls">
                                            <input type="number" class="form-control" name="order"
                                                @if (isset($data) && !empty($data) && isset($data->order)) value="{{ $data->order }}" @else value="1" @endif>
                                        </div>
                                    </div>
                                </div>


                            </div>


                            <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                <div class="text-left">
                                    <button type="submit" class="btn btn-primary">@lang('additional.buttons.submit')</button>
                                    <a type="button" href="{{ route('category.index') }}"
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
