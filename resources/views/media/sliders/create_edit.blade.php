@extends('layouts.app')
@section('menu_media', 'open')
@section('title')
    @if (isset($data) && !empty($data))
         Slayder yenilə
    @else
        Slayder əlavə et
    @endif
@endsection
@section('content')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/flags/css/flag-icons.min.css') }}">
@endsection
@section('javascript')
    @include('layouts.ckeditor.ckeditorService', [
        'uploadUrl' => route('ckEditorUpload'),
        'editors' => ['az_description', 'ru_description', 'en_description'],
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
                             Slayder yenilə
                        @else
                            Slayder əlavə et
                        @endif əlavə et
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
                            <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
                        </li>
                        <li>
                            <a href="{{ route('sliders.index') }}">Slayderlər</a>
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

                                <ul class="nav nav-tabs nav-justified primary">
                                    <li class="active">
                                        <a href="#az" data-toggle="tab">
                                            <span class="flag-icon flag-icon-az"></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#ru" data-toggle="tab">
                                            <span class="flag-icon flag-icon-ru"></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#en" data-toggle="tab">
                                            <span class="flag-icon flag-icon-um"></span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content primary">

                                    <div class="tab-pane fade in active" id="az">
                                        <br>
                                        
                                        <textarea class="form-control az_description" placeholder="Açıqlama daxil edin ..." name="az_description"
                                            style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{{ isset($data) && !empty($data) && !empty($data->description['az_description']) ? $data->description['az_description'] : null }}</textarea>
                                        <br>

                                    </div>
                                    <div class="tab-pane fade" id="ru">
                                        <br>
                                     
                                        <textarea class="form-control ru_description" placeholder="Введите описание ..." name="ru_description"
                                            style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{{ isset($data) && !empty($data) && isset($data->description['ru_description']) ? $data->description['ru_description'] : null }}</textarea>
                                        <br>

                                    </div>
                                    <div class="tab-pane fade" id="en">
                                        <br>
                                       
                                        <textarea class="bootstrap-wysihtml5-textarea  en_description" placeholder="Enter the description ..."
                                            name="en_description" style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{{ isset($data) && !empty($data) && isset($data->description['en_description']) ? $data->description['en_description'] : null }}</textarea>
                                        <br>

                                    </div>

                                </div>

                            </div>
                            <br>


                            <div class="row">


                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <label class="form-label">Şəkil</label>
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
                                        <label class="form-label">Url</label>
                                        <div class="controls">
                                            <input type="url" class="form-control" name="url"
                                                @if (isset($data) && !empty($data) && isset($data->url)) value="{{ $data->url }}" @endif>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <label class="form-label">Sıralama</label>
                                        <div class="controls">
                                            <input type="number" class="form-control" name="order"
                                                @if (isset($data) && !empty($data) && isset($data->order)) value="{{ $data->order }}" @else value="1" @endif>
                                        </div>
                                    </div>
                                </div>


                            </div>


                            <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                <div class="text-left">
                                    <button type="submit" class="btn btn-primary">Təsdiq et</button>
                                    <a type="button" href="{{ route('sliders.index') }}" class="btn">Ləğv
                                        et</a>
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
