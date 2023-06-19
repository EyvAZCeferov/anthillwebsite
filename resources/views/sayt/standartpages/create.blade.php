@extends('layouts.app')
@section('menu_website', 'open')
@section('title')
    @if (isset($data) && !empty($data))
        Standart səhifə yenilə
    @else
        Standart səhifə yarat
    @endif
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/flags/css/flag-icons.min.css') }}">
@endsection


@section('javascript')
    @include('layouts.ckeditor.ckeditorService', [
        'uploadUrl' => route('ckEditorUpload'),
        'editors' => ['az_description', 'ru_description', 'en_description', 'tr_description'],
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
                                Standart səhifə yenilə
                            @else
                                Standart səhifə yarat
                            @endif
                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
                            </li>
                            <li>
                                <a href="{{ route('standartpages.index') }}"> Səhifələr</a>
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
                                            {{-- <li>
                                                <a href="#tr" data-toggle="tab">
                                                    <span class="flag-icon flag-icon-tr"></span>
                                                </a>
                                            </li> --}}


                                        </ul>

                                        <div class="tab-content primary">

                                            <div class="tab-pane fade in active" id="az">
                                                <input type="text" placeholder="Adı daxil edin..." class="form-control"
                                                    name="az_name"
                                                    value="{{ !empty($data) && isset($data->name['az_name']) ? $data->name['az_name'] : null }}">
                                                <br>
                                                <textarea class="form-control az_description" placeholder="Açıqlama daxil edin ..." name="az_description"
                                                    style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{!! isset($data) && !empty($data) && $data->description != null && isset($data->description['az_description'])
                                                        ? $data->description['az_description']
                                                        : null !!}</textarea>
                                                <br>

                                                @include('layouts.seo.createseo', [
                                                    'langKey' => 'az',
                                                    "data"=>isset($data) && !empty($data) ? $data->seo : null
                                                ])
                                                <br>

                                            </div>
                                            <div class="tab-pane fade" id="ru">
                                                <input type="text" placeholder="Введите имя ..." class="form-control"
                                                    name="ru_name"
                                                    value="{{ !empty($data) && isset($data->name['ru_name']) ? $data->name['ru_name'] : null }}">
                                                <br>
                                                <textarea class="form-control ru_description" placeholder="Введите описание ..." name="ru_description"
                                                    style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{!! isset($data) && !empty($data) && $data->description != null && isset($data->description['ru_description'])
                                                        ? $data->description['ru_description']
                                                        : null !!}</textarea>
                                                <br>

                                                @include('layouts.seo.createseo', [
                                                    'langKey' => 'ru',
                                                    "data"=>isset($data) && !empty($data) ? $data->seo : null
                                                ])
                                                <br>

                                            </div>
                                            <div class="tab-pane fade" id="en">
                                                <input type="text" placeholder="Enter the name ..." class="form-control"
                                                    name="en_name"
                                                    value="{{ !empty($data) && isset($data->name['en_name']) ? $data->name['en_name'] : null }}">
                                                <br>
                                                <textarea class="form-control en_description" placeholder="Enter a description ..." name="en_description"
                                                    style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{!! isset($data) && !empty($data) && $data->description != null && isset($data->description['en_description'])
                                                        ? $data->description['en_description']
                                                        : null !!}</textarea>
                                                <br>

                                                @include('layouts.seo.createseo', [
                                                    'langKey' => 'en',
                                                    "data"=>isset($data) && !empty($data) ? $data->seo : null
                                                ])
                                                <br>

                                            </div>

                                            {{-- <div class="tab-pane fade" id="tr">
                                                <input type="text" placeholder="İsim giriniz ..." class="form-control"
                                                    name="tr_name"
                                                    value="{{ !empty($data) && isset($data->name['tr_name']) ? $data->name['tr_name'] : null }}">
                                                <br>
                                                <textarea class="form-control tr_description" placeholder="Açıklama giriniz ..." name="tr_description"
                                                    style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{!! isset($data) && !empty($data) && $data->description != null && isset($data->description['tr_description'])
                                                        ? $data->description['tr_description']
                                                        : null !!}</textarea>
                                                <br>
                                            </div> --}}

                                        </div>

                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">Tip</label>
                                                <div class="controls">
                                                    <select name="type" class="form-control">
                                                        <option value="about" @if (!empty($data) && $data->type == 'about') selected @endif >Haqqımızda</option>
                                                        <option value="termofuse" @if (!empty($data) && $data->type == 'termofuse') selected @endif>İstifadə şərtləri</option>
                                                        <option value="privarcypolicy" @if (!empty($data) && $data->type == 'privarcypolicy') selected @endif>Məxfilik siyasəti</option>
                                                        <option value="cancellationandrefundpolicy" @if (!empty($data) && $data->type == 'cancellationandrefundpolicy') selected @endif>Ləğv etmə və geri qaytarma siyasəti</option>
                                                        <option value="homepage" @if (!empty($data) && $data->type == 'homepage') selected @endif>Ana Səhifə</option>
                                                        <option value="services" @if (!empty($data) && $data->type == 'services') selected @endif>Xidmətlər</option>
                                                        <option value="customers" @if (!empty($data) && $data->type == 'customers') selected @endif>Müştərilər</option>
                                                        <option value="login" @if (!empty($data) && $data->type == 'login') selected @endif>Daxil ol</option>
                                                        <option value="register" @if (!empty($data) && $data->type == 'register') selected @endif>Qeydiyyat</option>
                                                        <option value="companies" @if (!empty($data) && $data->type == 'companies') selected @endif>Şirkətlər</option>
                                                        <option value="wishlist" @if (!empty($data) && $data->type == 'wishlist') selected @endif>İstək listi</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">Şəkil</label>
                                                <br>
                                                <div class="row">
                                                    @if (isset($data) && $data != null && $data->image != null)
                                                        <div class="col-sm-12 col-md-3">    
                                                            <img style="object-fit:contain;width:100%;"
                                                                    src="{{App\Helpers\Helper::getImageUrl($data->image,'standartpages')}}">
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
                                                <button type="submit" class="btn btn-primary">Təsdiq et</button>
                                                <a type="button" href="{{ route('standartpages.index') }}"
                                                    class="btn">Ləğv
                                                    et</a>
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
