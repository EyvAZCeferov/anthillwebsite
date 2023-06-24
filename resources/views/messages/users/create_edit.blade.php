@extends('layouts.app')
@section('menu_orders', 'open')
@section('title')
    @if (isset($data) && !empty($data) && isset($data->name_surname) && !empty($data->name_surname))
        {{ $data->name_surname }}
    @else
        İstifadəçi
    @endif
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/flags/css/flag-icons.min.css') }}">
    <style>
        li#yasayiskompleksi_tab_c {
            display: none;
        }

        .img_e {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .img_e img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .img_e button {
            position: absolute;
            top: 0;
            right: 0;
            width: 30px;
        }
    </style>
@endsection
@section('javascript')
    <script>
        $("select#user_type").on('change', function() {
            $("ul#nav_tab li#company_information_tab").remove();
            $("ul#nav_tab li#yasayiskompleksi_tab_c").css('display', 'none');
            if (this.value != 1) {
                $("ul#nav_tab").append(
                    '<li class="" id="company_information_tab"> <a href="#company_information" data-toggle="tab"> <span class="">Şirkət məlumatları</span> </a> </li>'
                );
            }
            if (this.value == 4) {
                $("ul#nav_tab li#yasayiskompleksi_tab_c").css('display', 'table-cell');
            }
        });

        $(function() {
            if ($("select#user_type").val() != 1) {
                $("ul#nav_tab").append(
                    '<li class="" id="company_information_tab"> <a href="#company_information" data-toggle="tab"> <span class="">Şirkət məlumatları</span> </a> </li>'
                );
            }
            if ($("select#user_type").val() == 4) {
                $("ul#nav_tab li#yasayiskompleksi_tab_c").css('display', 'table-cell');
            }
        })
    </script>

    {{-- Select --}}
    @if (isset($data) && !empty($data))
        <script>
            $("select#user_type option").each(function() {
                $("ul#nav_tab li#company_information_tab").remove();
                $("ul#nav_tab li#yasayiskompleksi_tab_c").css('display', 'none');
                if ($(this).is(':selected')) {
                    if (this.value != 1) {
                        $("ul#nav_tab").append(
                            '<li class="" id="company_information_tab"> <a href="#company_information" data-toggle="tab"> <span class="">Şirkət məlumatları</span> </a> </li>'
                        );
                    }

                    if (this.value == 4) {
                        $("ul#nav_tab li#yasayiskompleksi_tab_c").css('display', 'table-cell');
                    }
                }
            });
        </script>
    @endif
    {{-- Select --}}
    {{-- Add Tab --}}
    <script>
        function makeid(length) {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            let counter = 0;
            while (counter < length) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
                counter += 1;
            }
            return result;
        }

        function addareaoftab(type) {
            var idofelement = makeid(11);
            if (type == "parametr") {
                var element =
                    `<div class="row my-2 px-3" id="${idofelement}"><input type="hidden" name="area[${idofelement}][type_of_action]" value="2" /><div class="col-sm-6 col-md-6 col-lg-5"><label>Tip</label><select class="form-control" name="area[${idofelement}][type]"><option value="1" >Korpus sayı</option><option value="2" >Mərtəbə sayı</option><option value="3" >Mərtəbədəki mənzil sayı</option><option value="4" >Blok sayı</option><option value="5" >Ümumi mənzil sayı</option><option value="6" >Blokdakı lift sayı</option></select></div><div class="col-sm-6 col-md-6 col-lg-3"><label>Açıqlama</label><input class="form-control" name="area[${idofelement}][az_description]"/></div><div class="col-sm-6 col-md-6 col-lg-2"><label>Sıra nömrəsi</label><input class="form-control" name="area[${idofelement}][order_a]"/></div><div class="col-sm-6 col-md-6 col-lg-1 align-center align-items-center justify-content-center justify-center"><button type="button" class='btn btn-danger' onclick="delete_area('${idofelement}')"><i class='fa fa-trash'></i></button></div></div>`;
            } else {
                var element =
                    `<div class="row my-2 px-3" id="${idofelement}"><input type="hidden" name="area[${idofelement}][type_of_action]" value="1" /><div class="col-sm-6 col-md-6 col-lg-2"><label>Otaq sayı</label><select class="form-control" name="area[${idofelement}][type]"><option value="1" >1 otaq</option><option value="2" >2 otaq</option><option value="3" >3 otaq</option><option value="4" >4 otaq</option><option value="5" >5 otaq</option><option value="6" >6 otaq</option><option value="7" >7 otaq</option><option value="8" >8 otaq</option><option value="9" >9 otaq</option><option value="10" >10 otaq</option></select></div><div class="col-sm-6 col-md-6 col-lg-3"><label>Açıqlama</label><textarea class="form-control" name="area[${idofelement}][az_description]"></textarea></div><div class="col-sm-6 col-md-6 col-lg-1"><label>Sıra nömrəsi</label><input class="form-control" name="area[${idofelement}][order_a]"/></div><div class="col-sm-6 col-md-6 col-lg-1"><label>Kvadrat m²</label><input class="form-control" name="area[${idofelement}][area]"/></div><div class="col-sm-6 col-md-6 col-lg-1"><label>Satış qiyməti €</label><input class="form-control" name="area[${idofelement}][price_sale]"/></div><div class="col-sm-6 col-md-6 col-lg-1"><label>Kv m qiyməti €</label><input class="form-control" name="area[${idofelement}][price_for_meter]"/></div><div class="col-sm-6 col-md-6 col-lg-2"><label>Şəkillər</label><input type="file" multiple class="form-control" name="area[${idofelement}][images][]"/></div><div class="col-sm-6 col-md-6 col-lg-1 align-center align-items-center justify-content-center justify-center"><button type="button" class='btn btn-danger' onclick="delete_area('${idofelement}')"><i class='fa fa-trash'></i></button></div></div>`;
            }
            $(`div#${type}`).append(element);
        }

        function delete_area(id, type = null) {
            if (type != null && type.length > 0) {
                $.ajax({
                    url: "{{ route('api.deleteadditionaltab') }}",
                    dataType: 'json',
                    data: {
                        tab_id: id,
                    },
                    type: 'delete',
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
            $(`div#${id}`).remove();
        }
    </script>
    {{-- Add Tab --}}
    {{-- Delete Image --}}
    @if (isset($data) && !empty($data))
        <script>
            function delete_img(key, type, tabid = null) {
                $.ajax({
                    url: "{{ route('api.deleteimage') }}",
                    dataType: 'json',
                    data: {
                        key: key,
                        type: type,
                        userid: {{ $data->id }},
                        tabid: tabid ?? null,
                    },
                    type: 'delete',
                    success: function(data) {
                        if (data == true) {
                            $(`#${type}_${key}`).remove();
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        </script>
    @endif
    {{-- Delete Image --}}
@endsection
@section('content')
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">
                            @if (isset($data) && $data != null)
                                İstifadəçi yenilə
                            @else
                                İstifadəçi əlavə et
                            @endif
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'users',
                                    'harddelete' => false,
                                    'add' => false,
                                    'home' => true,
                                    'restoreall' => false,
                                ])
                            </span>
                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang("additional.urls.dashboard")</a>
                            </li>
                            <li>
                                <a href="{{ route('users.index') }}">İstifadəçilər</a>
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
                                action="{{ isset($data) && !empty($data) ? route('users.update', $data->id) : route('users.store') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @if (isset($data) && !empty($data))
                                    @method('PATCH')
                                @endif

                                <div class="row">
                                    <ul class="nav nav-tabs nav-justified primary" id="nav_tab">
                                        <li class="active">
                                            <a href="#personal_information" data-toggle="tab">
                                                <span class="">Şəxsi məlumatlar</span>
                                            </a>
                                        </li>
                                        @if (isset($data) && !empty($data) && $data->type != 1)
                                            <li class="" id="company_information_tab">
                                                <a href="#company_information" data-toggle="tab">
                                                    <span class="">Şirkət məlumatları</span>
                                                </a>
                                            </li>
                                        @endif
                                        <li class="" id="yasayiskompleksi_tab_c">
                                            <a href="#yasayiskompleksi_tab" data-toggle="tab">
                                                <span class="">Yaşayış kompleksi məlumatları</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content primary">

                                        <div class="tab-pane fade in active" id="personal_information">
                                            <br>
                                            <div class="row px-5">
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <label for="">Ad Soyad</label>
                                                    <input type="text"
                                                        value="{{ isset($data) && !empty($data) && $data->name_surname != null ? $data->name_surname : null }}"
                                                        placeholder="Ad Soyad daxil edin..." class="form-control"
                                                        name="name_surname">
                                                    <br>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <label for="">Email </label>
                                                    <input type="text"
                                                        value="{{ isset($data) && !empty($data) && $data->email != null ? $data->email : null }}"
                                                        placeholder="Email adres daxil edin..." class="form-control"
                                                        name="email">
                                                    <br>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <label for="">Əsas Telefon</label>

                                                    <input type="text"
                                                        value="{{ isset($data) && !empty($data) && $data->phone != null ? $data->phone : null }}"
                                                        placeholder="Əsas nömrə daxil edin..." class="form-control"
                                                        name="phone">
                                                    <br>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <label for="">İkinci Telefon</label>

                                                    <input type="text"
                                                        value="{{ isset($data) && !empty($data) && $data->phone_2 != null ? $data->phone_2 : null }}"
                                                        placeholder="İkinci nömrə daxil edin..." class="form-control"
                                                        name="phone_2">
                                                    <br>
                                                </div>

                                                @if (isset($data) && !empty($data) && $data->type == 2)
                                                    <div class="col-sm-6 col-md-6 col-lg-4">

                                                        <label for="">Aid olduğu Şirkət</label>
                                                        <select name="top_company_id" class="form-control">
                                                            @foreach ($companies as $company)
                                                                <option value="{{ $company->id }}">
                                                                    {{ $company->additionalinfo->company_name['az_name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    <div class="col-sm-6 col-md-6 col-lg-4">

                                                        <label for="">Aid olduğu Şirkət</label>
                                                        <select name="top_company_id" class="form-control">
                                                            <option value="">Şirkət seç</option>
                                                            @foreach ($companies as $company)
                                                                <option value="{{ $company->id }}">
                                                                    {{ $company->additionalinfo->company_name['az_name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                @if (isset($data) &&
                                                        !empty($data) &&
                                                        auth()->check() &&
                                                        auth()->user()->hasRole('Admin'))
                                                    <div class="col-sm-6 col-md-6 col-lg-4">
                                                        <label for="">Orijinal şifrə</label>

                                                        <input type="text"
                                                            value="{{ isset($data) && !empty($data) && $data->additionalinfo->original_pass != null ? $data->additionalinfo->original_pass : null }}"
                                                            placeholder="Orijinal şifrə daxil edin..." class="form-control"
                                                            name="original_pass">
                                                        <br>
                                                    </div>
                                                @endif

                                                @if (isset($data) && !empty($data))
                                                    <div class="col-sm-6 col-md-6 col-lg-4">
                                                        <label for="">Yeni şifrə</label>

                                                        <input type="password" placeholder="Yeni şifrə daxil edin..."
                                                            class="form-control" name="password">
                                                        <br>
                                                    </div>
                                                @endif

                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <label for="">Tipi</label>

                                                    <select name="type" class="form-control" id="user_type">
                                                        @if (!isset($data) && empty($data))
                                                            <option value="">İstifadəçi tipi seç</option>
                                                        @endif
                                                        <option value="1"
                                                            @if (isset($data) && !empty($data) && $data->type == 1) selected @endif>Normal
                                                            İstifadəçi</option>
                                                        <option value="2"
                                                            @if (isset($data) && !empty($data) && $data->type == 2) selected @endif>Vasitəçi
                                                        </option>
                                                        <option value="3"
                                                            @if (isset($data) && !empty($data) && $data->type == 3) selected @endif>Agentlik
                                                        </option>
                                                        <option value="4"
                                                            @if (isset($data) && !empty($data) && $data->type == 4) selected @endif>Yaşayış
                                                            kompleksi
                                                        </option>
                                                    </select>
                                                    <br>
                                                </div>
                                            </div>
                                            <br>

                                        </div>

                                        <div class="tab-pane fade in" id="company_information">
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
                                                <li>
                                                    <a href="#tr" data-toggle="tab">
                                                        <span class="flag-icon flag-icon-tr"></span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content primary">

                                                <div class="tab-pane fade in active" id="az">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="">Şirkət adı</label>
                                                                <input type="text"
                                                                    value="{{ isset($data) && !empty($data) && $data->additionalinfo->company_name != null && isset($data->additionalinfo->company_name['az_name']) ? $data->additionalinfo->company_name['az_name'] : null }}"
                                                                    placeholder="Şirkət adı daxil edin..."
                                                                    class="form-control" name="company_az_name">
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="">Şirkət adresi</label>
                                                                <input type="text"
                                                                    value="{{ isset($data) && !empty($data) && $data->additionalinfo->company_address != null && isset($data->additionalinfo->company_address['az_address']) ? $data->additionalinfo->company_address['az_address'] : null }}"
                                                                    placeholder="Şirkət adresi daxil edin..."
                                                                    class="form-control" name="company_az_address">
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="">Şirkət iş saatı</label>
                                                                <input type="text"
                                                                    value="{{ isset($data) && !empty($data) && $data->additionalinfo->company_times != null && isset($data->additionalinfo->company_times['az_time']) ? $data->additionalinfo->company_times['az_time'] : null }}"
                                                                    placeholder="Şirkət iş saatı daxil edin..."
                                                                    class="form-control" name="company_az_time">
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="">Şirkət açıqlaması</label>
                                                                <textarea type="text" placeholder="Şirkət açıqlaması daxil edin..." class="form-control"
                                                                    name="company_az_description">{{ isset($data) && !empty($data) && $data->additionalinfo->company_description != null && isset($data->additionalinfo->company_description['az_description']) ? $data->additionalinfo->company_description['az_description'] : null }}</textarea>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                                            @if (isset($data) && isset($data->additionalinfo->company_image) && !empty($data->additionalinfo->company_image))
                                                                <img src="{{ $data->additionalinfo->company_image }}"
                                                                    class="img-fluid img-responsive"
                                                                    alt="{{ $data->additionalinfo->company_name['az_name'] }}" />
                                                            @endif
                                                            <div class="form-group">
                                                                <label for="">Şirkət profil şəkli</label>
                                                                <input type="file" class="form-control"
                                                                    name="company_image">
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                                            @if (isset($data) &&
                                                                    isset($data->additionalinfo->company_background_image) &&
                                                                    !empty($data->additionalinfo->company_background_image))
                                                                <img src="{{ $data->additionalinfo->company_background_image }}"
                                                                    class="img-fluid img-responsive"
                                                                    alt="{{ $data->additionalinfo->company_name['az_name'] }}" />
                                                            @endif
                                                            <div class="form-group">
                                                                <label for="">Şirkət arxafon şəkli</label>
                                                                <input type="file" class="form-control"
                                                                    name="company_background_image">
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="">Şirkət latitude</label>
                                                                <input type="text"
                                                                    placeholder="Şirkət latitude daxil edin..."
                                                                    class="form-control" name="company_latitude"
                                                                    value="{{ isset($data) && !empty($data) && $data->additionalinfo->company_address != null && isset($data->additionalinfo->company_address['latitude']) ? $data->additionalinfo->company_address['latitude'] : null }}" />
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="">Şirkət longitude</label>
                                                                <input type="text"
                                                                    placeholder="Şirkət longitude daxil edin..."
                                                                    class="form-control" name="company_longitude"
                                                                    value="{{ isset($data) && !empty($data) && $data->additionalinfo->company_address != null && isset($data->additionalinfo->company_address['longitude']) ? $data->additionalinfo->company_address['longitude'] : null }}" />
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade in" id="yasayiskompleksi_tab">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    @if (isset($data) && isset($data->additionalinfo->company_images) && !empty($data->additionalinfo->company_images))
                                                        @foreach ($data->additionalinfo->company_images as $key => $value)
                                                            <div class="img_e" id="company_images_{{ $key }}">
                                                                <img src="{{ $value }}" />
                                                                <button type="button" class="btn btn-danger"
                                                                    onclick="delete_img({{ $key }},'company_images')"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    <div class="form-group">
                                                        <label for="">Yaşayış kompleksi şəkilləri</label>
                                                        <input type="file" class="form-control"
                                                            name="company_images[]" multiple>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="">Yaşayış kompleksi vebsayt</label>
                                                        <input type="text" class="form-control"
                                                            name="company_contact_infos_website"
                                                            value="{{ isset($data) && $data->type == 4 && !empty($data->additionalinfo->company_contact_infos) ? $data->additionalinfo->company_contact_infos['website'] : null }}">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="">Yaşayış kompleksi email</label>
                                                        <input type="text" class="form-control"
                                                            name="company_contact_infos_email"
                                                            value="{{ isset($data) && $data->type == 4 && !empty($data->additionalinfo->company_contact_infos) ? $data->additionalinfo->company_contact_infos['email'] : null }}">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="">Yaşayış kompleksi telefon</label>
                                                        <input type="text" class="form-control"
                                                            name="company_contact_infos_phone"
                                                            value="{{ isset($data) && $data->type == 4 && !empty($data->additionalinfo->company_contact_infos) ? $data->additionalinfo->company_contact_infos['phone'] : null }}">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="">Yaşayış kompleksi Çatdırılma Tarixi</label>
                                                        <input type="text" class="form-control"
                                                            name="az_delivery_date"
                                                            value="{{ isset($data) && $data->type == 4 && !empty($data->additionalinfo->delivery_date) ? $data->additionalinfo->delivery_date['az_delivery_date'] : null }}">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="">Yaşayış kompleksi Minimum satılma
                                                            qiyməti</label>
                                                        <input type="text" class="form-control" name="min_price_sale"
                                                            value="{{ isset($data) && $data->type == 4 && !empty($data->additionalinfo->company_prices) ? $data->additionalinfo->company_prices['min_price_sale'] : null }}">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="">Yaşayış kompleksi Maksimum satılma
                                                            qiyməti</label>
                                                        <input type="text" class="form-control" name="max_price_sale"
                                                            value="{{ isset($data) && $data->type == 4 && !empty($data->additionalinfo->company_prices) ? $data->additionalinfo->company_prices['max_price_sale'] : null }}">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="">Yaşayış kompleksi kv-a görə satılma
                                                            qiyməti</label>
                                                        <input type="text" class="form-control" name="kv_price_sale"
                                                            value="{{ isset($data) && $data->type == 4 && !empty($data->additionalinfo->company_prices) ? $data->additionalinfo->company_prices['kv_price_sale'] : null }}">
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                Parametrlər &emsp; <button type="button" class='btn btn-info'
                                                    onclick="addareaoftab('parametr')"> <i class="fa fa-plus"></i>
                                                </button>
                                                <div id="parametr" class="w-100 m-0 p-2">
                                                    @if (isset($data->additionalinfo->useradditionaltabs) && !empty($data->additionalinfo->useradditionaltabs))
                                                        @foreach ($data->additionalinfo->useradditionaltabs->where('type_of_action', 2) as $tab)
                                                            <div class="row my-2 px-3" id="{{ $tab->id }}">
                                                                <input type="hidden"
                                                                    name="area[{{ $tab->id }}][id]"
                                                                    value="{{ $tab->id }}" />
                                                                <input type="hidden"
                                                                    name="area[{{ $tab->id }}][type_of_action]"
                                                                    value="{{ $tab->type_of_action }}" />
                                                                <div class="col-sm-6 col-md-6 col-lg-5">
                                                                    <label>Tip</label><select class="form-control"
                                                                        name="area[{{ $tab->id }}][type]">
                                                                        <option
                                                                            @if (isset($tab->type) && $tab->type == 1) selected @endif
                                                                            value="1">Korpus sayı</option>
                                                                        <option
                                                                            @if (isset($tab->type) && $tab->type == 2) selected @endif
                                                                            value="2">Mərtəbə sayı</option>
                                                                        <option
                                                                            @if (isset($tab->type) && $tab->type == 3) selected @endif
                                                                            value="3">Mərtəbədəki mənzil sayı
                                                                        </option>
                                                                        <option
                                                                            @if (isset($tab->type) && $tab->type == 4) selected @endif
                                                                            value="4">Blok sayı</option>
                                                                        <option
                                                                            @if (isset($tab->type) && $tab->type == 5) selected @endif
                                                                            value="5">Ümumi mənzil sayı</option>
                                                                        <option
                                                                            @if (isset($tab->type) && $tab->type == 6) selected @endif
                                                                            value="6">Blokdakı lift sayı</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6 col-md-6 col-lg-3">
                                                                    <label>Açıqlama</label><input class="form-control"
                                                                        name="area[{{ $tab->id }}][az_description]"
                                                                        value="{{ $tab->description['az_description'] }}" />
                                                                </div>
                                                                <div class="col-sm-6 col-md-6 col-lg-2"><label>Sıra
                                                                        nömrəsi</label><input class="form-control"
                                                                        name="area[{{ $tab->id }}][order_a]"
                                                                        value="{{ $tab->order_a }}" /></div>
                                                                <div
                                                                    class="col-sm-6 col-md-6 col-lg-1 align-center align-items-center justify-content-center justify-center">
                                                                    <button type="button" class='btn btn-danger'
                                                                        onclick="delete_area('{{ $tab->id }}','parametr')"><i
                                                                            class='fa fa-trash'></i></button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                Mənzillər &emsp; <button type="button" class='btn btn-info'
                                                    onclick="addareaoftab('flat')"> <i class="fa fa-plus"></i> </button>
                                                <div id="flat" class="w-100 m-0 p-2">
                                                    @if (isset($data->additionalinfo->useradditionaltabs) && !empty($data->additionalinfo->useradditionaltabs))
                                                        @foreach ($data->additionalinfo->useradditionaltabs->where('type_of_action', 1) as $tab)
                                                            <div class="row my-2 px-3" id="{{ $tab->id }}">
                                                                <input type="hidden"
                                                                    name="area[{{ $tab->id }}][id]"
                                                                    value="{{ $tab->id }}" />
                                                                <input type="hidden"
                                                                    name="area[{{ $tab->id }}][type_of_action]"
                                                                    value="{{ $tab->type_of_action }}" />
                                                                <div class="col-sm-6 col-md-6 col-lg-2"><label>Otaq
                                                                        sayı</label><select class="form-control"
                                                                        name="area[{{ $tab->id }}][type]">
                                                                        <option
                                                                            @if (isset($tab->type) && !empty($tab->type) && $tab->type == 1) selected @endif
                                                                            value="1">1 otaq</option>
                                                                        <option
                                                                            @if (isset($tab->type) && !empty($tab->type) && $tab->type == 2) selected @endif
                                                                            value="2">2 otaq</option>
                                                                        <option
                                                                            @if (isset($tab->type) && !empty($tab->type) && $tab->type == 3) selected @endif
                                                                            value="3">3 otaq</option>
                                                                        <option
                                                                            @if (isset($tab->type) && !empty($tab->type) && $tab->type == 4) selected @endif
                                                                            value="4">4 otaq</option>
                                                                        <option
                                                                            @if (isset($tab->type) && !empty($tab->type) && $tab->type == 5) selected @endif
                                                                            value="5">5 otaq</option>
                                                                        <option
                                                                            @if (isset($tab->type) && !empty($tab->type) && $tab->type == 6) selected @endif
                                                                            value="6">6 otaq</option>
                                                                        <option
                                                                            @if (isset($tab->type) && !empty($tab->type) && $tab->type == 7) selected @endif
                                                                            value="7">7 otaq</option>
                                                                        <option
                                                                            @if (isset($tab->type) && !empty($tab->type) && $tab->type == 8) selected @endif
                                                                            value="8">8 otaq</option>
                                                                        <option
                                                                            @if (isset($tab->type) && !empty($tab->type) && $tab->type == 9) selected @endif
                                                                            value="9">9 otaq</option>
                                                                        <option
                                                                            @if (isset($tab->type) && !empty($tab->type) && $tab->type == 10) selected @endif
                                                                            value="10">10 otaq</option>
                                                                    </select></div>
                                                                <div class="col-sm-6 col-md-6 col-lg-3">
                                                                    <label>Açıqlama</label>
                                                                    <textarea class="form-control" name="area[{{ $tab->id }}][az_description]">{{ $tab->description['az_description'] }}</textarea>
                                                                </div>
                                                                <div class="col-sm-6 col-md-6 col-lg-1"><label>Sıra
                                                                        nömrəsi</label><input class="form-control"
                                                                        name="area[{{ $tab->id }}][order_a]"
                                                                        value="{{ $tab->order_a }}" /></div>
                                                                <div class="col-sm-6 col-md-6 col-lg-1"><label>Kvadrat
                                                                        m²</label><input class="form-control"
                                                                        name="area[{{ $tab->id }}][area]"
                                                                        value="{{ $tab->area }}" /></div>
                                                                <div class="col-sm-6 col-md-6 col-lg-1"><label>Satış
                                                                        qiyməti €</label><input class="form-control"
                                                                        name="area[{{ $tab->id }}][price_sale]"
                                                                        value="{{ $tab->price_sale }}" /></div>
                                                                <div class="col-sm-6 col-md-6 col-lg-1"><label>Kv m qiyməti
                                                                        €</label><input class="form-control"
                                                                        name="area[{{ $tab->id }}][price_for_meter]"
                                                                        value="{{ $tab->price_for_meter }}" />
                                                                </div>
                                                                <div class="col-sm-6 col-md-6 col-lg-2">
                                                                    <label>Şəkillər</label>
                                                                    <br />
                                                                    @foreach ($tab->images as $key => $value)
                                                                        <div class="img_e"
                                                                            id="img_e_{{ $key }}">
                                                                            <img src="{{ $value }}" />
                                                                            <button type="button" class="btn btn-danger"
                                                                                onclick="delete_img({{ $key }},'img_e_',{{ $tab->id }})"><i
                                                                                    class="fa fa-trash"></i></button>
                                                                        </div>
                                                                    @endforeach
                                                                    <input type="file" multiple class="form-control"
                                                                        name="area[{{ $tab->id }}][images][]" />
                                                                </div>
                                                                <div
                                                                    class="col-sm-6 col-md-6 col-lg-1 align-center align-items-center justify-content-center justify-center">
                                                                    <button type="button" class='btn btn-danger'
                                                                        onclick="delete_area('{{ $tab->id }}','flats')"><i
                                                                            class='fa fa-trash'></i></button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <br>

                                    <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-primary">@lang("additional.buttons.submit")</button>
                                            <a type="button" href="{{ route('category.index') }}" class="btn">@lang("additional.buttons.cancel")</a>
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
