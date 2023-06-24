@extends('layouts.app')
@section('menu_coupons', 'open')
@section('title')
    @if (isset($data) && !empty($data) && isset($data->id))
        {{ $data->name['az_name'] }} Kupon Məlumatlarını yenilə
    @else
        Kupon əlavə et
    @endif
@endsection
@section('content')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/flags/css/flag-icons.min.css') }}">
    <link href="{{ asset('assets/plugins/tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css"
        media="screen" />
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <!-- Switch -->
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #4bb543;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #4bb543;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <!-- Switch -->
    <style>
        .Checkcircle-container {
            padding: 2em;
            padding: 2em;
            display: flex;
            justify-content: center;
        }

        /* Hide the actual input */
        .Checkcircle-input {
            opacity: 0;
            position: absolute;
            margin: 0;
            z-index: -1;
            width: 0;
            height: 0;
            overflow: hidden;
            left: 0;
            pointer-events: none;
        }

        .Checkcircle-label {
            font-family: 'Roboto', sans-serif;
            text-transform: uppercase;
            cursor: pointer;
            color: var(--Checkcircle-color-understated);
        }

        .Checkcircle-label:hover {
            color: var(--Checkcircle-color-highlighted);
        }

        /*
                                        * 1. Sets checkcircle to the left of label text
                                        */
        .Checkcircle-check {
            position: relative;
            float: left;
            margin-left: var(--Checkcircle-check-margin-left);
            /* 1 */
            margin-right: 10px;
            height: 24px;
            width: 24px;
            border: 2px solid #ccc;
            border-radius: 50%;
            overflow: hidden;
            z-index: 1;
            margin-top: -5px;
        }

        /* Pseudo element to make a visible check mark */
        .Checkcircle-check::before {
            margin-top: 0.15em;
            margin-left: 0.62em;
            position: absolute;
            content: "";
            transform: rotate(45deg);
            display: block;
            width: 0;
            height: 0;
            box-shadow: 0 0 0 0,
                0 0 0 0,
                0 0 0 0,
                0 0 0 0,
                0 0 0 0,
                0 0 0 0,
                0 0 0 0 inset;
        }

        /**
                                        * Checked
                                        */

        .Checkcircle-input:checked+.Checkcircle-label .Checkcircle-check {
            background-color: #ccc;
            border-color: #ccc;
            transition: all 0.5s ease;
        }

        .Checkcircle-input:checked+.Checkcircle-label .Checkcircle-check::before {
            color: white;
            box-shadow: 0 0 0 10px, 10px -10px 0 6px, 32px 0 0 20px, 0px 32px 0 20px, -5px 5px 0 8px, 20px -12px 0 0px;
        }
    </style>
@endsection
@section('javascript')
    @include('layouts.seo.createseoscript')
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

    <script src="{{ asset('assets/plugins/tagsinput/js/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>

@endsection

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper" style=''>

        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">

                <div class="pull-left">
                    <h1 class="title">
                        @if (isset($data) && !empty($data) && isset($data->id))
                            {{ $data->name['az_name'] }} Kupon Məlumatlarını yenilə
                        @else
                            Kupon əlavə et
                        @endif
                        &nbsp;&nbsp;
                        <span>
                            @include('layouts.topbarbuttons', [
                                'routename' => 'coupons',
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
                            <a href="{{ route('coupons.index') }}">Kupon</a>
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
                            @if (isset($data) && !empty($data) && isset($data->id)) action="{{ route('coupons.update', $data->id) }}" @else action="{{ route('coupons.store') }}" @endif
                            method="post" enctype="multipart/form-data">
                            @if (isset($data) && !empty($data) && isset($data->id))
                                @method('PUT')
                            @endif
                            @csrf

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
                                        <input type="text"
                                            value="{{ isset($data) && !empty($data) && isset($data->name['az_name']) ? $data->name['az_name'] : null }}"
                                            placeholder="Adı daxil edin..." class="form-control" name="az_name">
                                        <br>
                                    </div>
                                    <div class="tab-pane fade" id="ru">
                                        <br>
                                        <input type="text"
                                            value="{{ isset($data) && !empty($data) && isset($data->name['ru_name']) ? $data->name['ru_name'] : null }}"
                                            placeholder="Введите имя ..." class="form-control" name="ru_name">

                                        <br>
                                    </div>
                                    <div class="tab-pane fade" id="en">
                                        <br>
                                        <input type="text"
                                            value="{{ isset($data) && !empty($data) && isset($data->name['en_name']) ? $data->name['en_name'] : null }}"
                                            placeholder="Enter the name ..." class="form-control" name="en_name">
                                        <br>
                                    </div>

                                </div>

                            </div>

                            <br>

                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label class="form-label"> Kod</label>
                                        <div class="controls">
                                            <input type="text"
                                                value="{{ isset($data) && !empty($data) && isset($data->code) ? $data->code : null }}"
                                                placeholder="Kodu Daxil edin ..." class="form-control" name="code">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label class="form-label"> Dəyər</label>
                                        <div class="controls">
                                            <input type="text"
                                                value="{{ isset($data) && !empty($data) && isset($data->value) ? $data->value : null }}"
                                                placeholder="Miqdarı Daxil edin ..." class="form-control"
                                                name="value">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label class="form-label"> Tip</label>
                                        <div class="controls">
                                            <select name="type" required class="form-control">
                                                <option value="0"
                                                    @if (isset($data) && !empty($data) && isset($data->type) && $data->type == 0) selected @endif>Bir tip seçin
                                                </option>
                                                <option value="1"
                                                    @if (isset($data) && !empty($data) && isset($data->type) && $data->type == 1) selected @endif>Faiz</option>
                                                <option value="2"
                                                    @if (isset($data) && !empty($data) && isset($data->type) && $data->type == 2) selected @endif>Ədəd</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <br>
                            <div class="col-sm-2 col-md-2">
                                <label for="">Bir dəfəlik istifadə</label>
                                <input @if (isset($data) && isset($data) && !empty($data) && $data->oneusing == 1) checked @endif type="checkbox"
                                    data-toggle="toggle" data-onstyle="success" data-offstyle="danger" name="oneusing">

                            </div>
                            <br>

                            <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                <div class="text-left">
                                    <button type="submit" class="btn btn-primary">@lang("additional.buttons.submit")</button>
                                    <a type="button" href="{{ route('coupons.index') }}" class="btn">Ləğv
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
