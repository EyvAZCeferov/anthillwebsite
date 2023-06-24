@extends('layouts.app')
@section('menu_website', 'open')
@section('title')
    @lang("additional.urls.settings")
@endsection

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
                        <h1 class="title">@lang("additional.urls.settings")</h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang("additional.urls.dashboard")</a>
                            </li>
                            <li>
                                <a href="{{ route('settings.index') }}">@lang("additional.urls.settings")</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">@lang("additional.urls.settings")</h2>
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
<div class="col-sm-12 col-md-12 col-lg-12">
                                                <br>

                                                <input type="text" name="en_title" class="form-control"
                                                    placeholder="Enter a title"
                                                    value="{{ $data != null && $data->title != null && isset($data->title['en_title']) ? $data->title['en_title'] : null }}">
                                                <br>
                                                <input type="text" name="en_address" class="form-control"
                                                    placeholder="Enter the address"
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

                                        </div>

                                    </div>

                                    <br>

                                    <div class="row">
                                        <h2>@lang("additional.forms.social_media")</h2>
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
                                                <label class="form-label">@lang("additional.forms.phone") </label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{ $data != null && $data->social_media != null && $data->social_media['mobile_phone'] != null ? $data->social_media['mobile_phone'] : null }}"
                                                        class="form-control" name="mobile_phone">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label">@lang("additional.forms.phone2") </label>
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
                                                <label class="form-label">@lang("additional.forms.email")</label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{ $data != null && $data->social_media != null && $data->social_media['email'] != null ? $data->social_media['email'] : null }}"
                                                        class="form-control" name="email">
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
                                                <label class="form-label">Yandex Metrica</label>
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

                                    {{-- <br>
                                    <div class="row">
                                        <h2>@lang("additional.forms.website_language")</h2>
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

                                    </div> --}}

                                    <br>

                                    <div class="row">
                                        <h2>@lang("additional.forms.image")</h2>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang("additional.forms.logo")</label>
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

                                        {{-- <div class="col-sm-12 col-md-6 col-lg-6">
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
                                        </div> --}}


                                    </div>

                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                            <div class="text-left">
                                                <button type="submit" class="btn btn-primary">@lang("additional.buttons.submit")</button>
                                                <a type="button" href="{{ route('settings.index') }}" class="btn">@lang("additional.buttons.cancel")</a>
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
