@extends('layouts.app')
@section('menu_website', 'open')
@section('title', 'Parametrlər')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/flags/css/flag-icons.min.css') }}">
    <link href="{{ asset('assets/plugins/tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css"
        media="screen" />
@endsection

@section('javascript')
    <script src="{{ asset('assets/plugins/tagsinput/js/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
@endsection

@section('content')
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">Parametrlər</h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
                            </li>
                            <li>
                                <a href="{{ route('settings.index') }}">Parametrlər</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">Parametrlər</h2>
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
                                    action="{{ $data != null ? route('settings.update', $data->id) : route('settings.store') }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @if ($data != null)
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
                                                <br>

                                                <input type="text" name="az_title" class="form-control"
                                                    placeholder="Başlıq Daxil edin"
                                                    value="{{ $data != null && $data->title != null && isset($data->title['az_title']) ? $data->title['az_title'] : null }}">
                                                <br>

                                                <input type="text" name="az_address" class="form-control"
                                                    placeholder="Adresi Daxil edin"
                                                    value="{{ $data != null && $data->address != null && isset($data->address['az_address']) ? $data->address['az_address'] : null }}">
                                                <br>

                                                <input type="text" name="az_open_hours" class="form-control"
                                                    placeholder="Açıq saatları Daxil edin"
                                                    value="{{ $data != null && $data->open_hours != null && isset($data->open_hours['az_open_hours']) ? $data->open_hours['az_open_hours'] : null }}">
                                                <br>
                                                <textarea class="form-control" placeholder="Açıqlama daxil edin ..." name="az_description" maxlength="300"
                                                    style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{!! $data != null && $data->description != null && isset($data->description['az_description'])
                                                        ? $data->description['az_description']
                                                        : null !!}</textarea>
                                                <br>

                                            </div>
                                            <div class="tab-pane fade" id="ru">
                                                <br>

                                                <input type="text" name="ru_title" class="form-control"
                                                    placeholder="Введите название"
                                                    value="{{ $data != null && $data->title != null && isset($data->title['ru_title']) ? $data->title['ru_title'] : null }}">
                                                <br>
                                                <input type="text" name="ru_address" class="form-control"
                                                    placeholder="Включите адрес"
                                                    value="{{ $data != null && $data->address != null && isset($data->address['ru_address']) ? $data->address['ru_address'] : null }}">
                                                <br>
                                                <input type="text" name="ru_open_hours" class="form-control"
                                                    placeholder="Введите часы работы"
                                                    value="{{ $data != null && $data->open_hours != null && isset($data->open_hours['ru_open_hours']) ? $data->open_hours['ru_open_hours'] : null }}">
                                                <br>
                                                <textarea class="form-control" placeholder="Введите описание ..." name="ru_description" maxlength="300"
                                                    style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{!! $data != null && $data->description != null && isset($data->description['ru_description'])
                                                        ? $data->description['ru_description']
                                                        : null !!}</textarea>
                                                <br>
                                            </div>
                                            <div class="tab-pane fade" id="en">
                                                <br>

                                                <input type="text" name="en_title" class="form-control"
                                                    placeholder="Enter a title"
                                                    value="{{ $data != null && $data->title != null && isset($data->title['en_title']) ? $data->title['en_title'] : null }}">
                                                <br>
                                                <input type="text" name="en_address" class="form-control"
                                                    placeholder="Include the address"
                                                    value="{{ $data != null && $data->address != null && isset($data->address['en_address']) ? $data->address['en_address'] : null }}">
                                                <br>
                                                <input type="text" name="en_open_hours" class="form-control"
                                                    placeholder="Enter open hours"
                                                    value="{{ $data != null && $data->open_hours != null && isset($data->open_hours['en_open_hours']) ? $data->open_hours['en_open_hours'] : null }}">
                                                <br>
                                                <textarea class="form-control" placeholder="Enter a description ..." name="en_description" maxlength="300"
                                                    style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{!! $data != null && $data->description != null && isset($data->description['en_description'])
                                                        ? $data->description['en_description']
                                                        : null !!}</textarea>
                                                <br>
                                            </div>
                                            {{-- <div class="tab-pane fade" id="tr">
                                                <br>

                                                <input type="text" name="tr_title" class="form-control"
                                                    placeholder="Adı giriniz"
                                                    value="{{ $data != null && $data->title != null && isset($data->title['tr_title']) ? $data->title['tr_title'] : null }}">
                                                <br>
                                                <input type="text" name="tr_address" class="form-control"
                                                    placeholder="Adresi giriniz"
                                                    value="{{ $data != null && $data->address != null && isset($data->address['tr_address']) ? $data->address['tr_address'] : null }}">
                                                <br>
                                                <input type="text" name="tr_open_hours" class="form-control"
                                                    placeholder="İş saatlerini giriniz"
                                                    value="{{ $data != null && $data->open_hours != null && isset($data->open_hours['tr_open_hours']) ? $data->open_hours['tr_open_hours'] : null }}">
                                                <br>
                                                <textarea class="form-control" placeholder="Açıklama giriniz ..." name="tr_description" maxlength="300"
                                                    style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">{!! $data != null && $data->description != null && isset($data->description['tr_description'])
                                                        ? $data->description['tr_description']
                                                        : null !!}</textarea>
                                                <br>
                                            </div> --}}

                                        </div>

                                    </div>

                                    <br>

                                    <div class="row">
                                        <h2>Sosial media linklər</h2>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label">Facebook Url</label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{ $data != null && $data->social_media != null && $data->social_media['facebook_url'] != null ? $data->social_media['facebook_url'] : null }}"
                                                        class="form-control" name="facebook_url">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label">Instagram Url</label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{ $data != null && $data->social_media != null && $data->social_media['instagram_url'] != null ? $data->social_media['instagram_url'] : null }}"
                                                        class="form-control" name="instagram_url">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label">Twitter Url</label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{ $data != null && $data->social_media != null && $data->social_media['youtube_url'] != null ? $data->social_media['youtube_url'] : null }}"
                                                        class="form-control" name="youtube_url">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label">Mobil Telefon </label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{ $data != null && $data->social_media != null && $data->social_media['mobile_phone'] != null ? $data->social_media['mobile_phone'] : null }}"
                                                        class="form-control" name="mobile_phone">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label">Telefon </label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{ $data != null && $data->social_media != null && $data->social_media['home_phone'] != null ? $data->social_media['home_phone'] : null }}"
                                                        class="form-control" name="home_phone">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label">Whatsapp</label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{ $data != null && $data->social_media != null && $data->social_media['whatsapp'] != null ? $data->social_media['whatsapp'] : null }}"
                                                        class="form-control" name="whatsapp">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label">E-mail</label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{ $data != null && $data->social_media != null && $data->social_media['email'] != null ? $data->social_media['email'] : null }}"
                                                        class="form-control" name="email">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label">Tiktok</label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{ $data != null && $data->social_media != null && $data->social_media['tiktok'] != null ? $data->social_media['tiktok'] : null }}"
                                                        class="form-control" name="tiktok">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label">Google Maps</label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{ $data != null && $data->social_media != null && $data->social_media['gmaps_url'] != null ? $data->social_media['gmaps_url'] : null }}"
                                                        class="form-control" name="gmaps_url">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label">Yandex Metrika</label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{!empty($data) && !empty($data->social_media) && isset($data->social_media['yandex_metrica']) && !empty($data->social_media['yandex_metrica']) ? $data->social_media['yandex_metrica'] : null }}"
                                                        class="form-control" name="yandex_metrica">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label">GOOGLE ANALYSTICS MEASUREMENT ID (G-Id for GOOGLE TAG MANAGER)  </label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{!empty($data) && !empty($data->social_media) && isset($data->social_media['GOOGLE_ANALYSTICS_MEASUREMENT_ID']) && !empty($data->social_media['GOOGLE_ANALYSTICS_MEASUREMENT_ID']) ? $data->social_media['GOOGLE_ANALYSTICS_MEASUREMENT_ID'] : null }}"
                                                        class="form-control" name="GOOGLE_ANALYSTICS_MEASUREMENT_ID">
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <br>
                                    <div class="row">
                                        <h2>Sayt Dili</h2>
                                    </div>
                                    <div class="row">
                                        @foreach (languages_admin() as $language)
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <input type="checkbox" name="languages[{{ $language->name }}]"
                                                        value="{{ $language->status }}"
                                                        @if ($language->status == true) checked @endif />
                                                    {{ $language->name }}
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                    <br>

                                    <div class="row">
                                        <h2>Şəkillər</h2>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">Logo</label>
                                                <br>
                                                <div class="row">
                                                    @if ($data != null && $data->logo != null)
                                                        <div class="col-sm-12 col-md-3">
                                                            <img style="max-width: 50%;object-fit:cover"
                                                                src="{{ App\Helpers\Helper::getImageUrl($data->logo, 'settings') }}">
                                                        </div>
                                                    @endif
                                                </div>
                                                <br>
                                                <div class="controls">
                                                    <input type="file" class="form-control" name="logo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">Ikon</label>
                                                <br>
                                                <div class="row">
                                                    @if ($data != null && $data->icon != null)
                                                        <div class="col-sm-12 col-md-3">
                                                            <img style="max-width: 50%;object-fit:cover"
                                                                src="{{ App\Helpers\Helper::getImageUrl($data->icon, 'settings') }}">
                                                        </div>
                                                    @endif
                                                </div>
                                                <br>
                                                <div class="controls">
                                                    <input type="file" class="form-control" name="icon">
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                            <div class="text-left">
                                                <button type="submit" class="btn btn-primary">Təsdiq et</button>
                                                <a type="button" href="{{ route('settings.index') }}"
                                                    class="btn">Ləğv
                                                    et</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
