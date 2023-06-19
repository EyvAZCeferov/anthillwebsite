@extends('layouts.app')
@section('menu_users', 'open')
@section('title')
    @if (isset($data) && !empty($data) && isset($data->name_surname) && !empty($data->name_surname))
        {{ $data->name_surname }}
    @else
        Istifadəçi
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
            if (this.value != 1) {
                $("ul#nav_tab").append(
                    '<li class="" id="company_information_tab"> <a href="#company_information" data-toggle="tab"> <span class="">Şirkət məlumatları</span> </a> </li>'
                );
            }

        });

        $(function() {
            if ($("select#user_type").val() != 1) {
                $("ul#nav_tab").append(
                    '<li class="" id="company_information_tab"> <a href="#company_information" data-toggle="tab"> <span class="">Şirkət məlumatları</span> </a> </li>'
                );
            }

        })
    </script>

    {{-- Select --}}
    @if (isset($data) && !empty($data))
        <script>
            $("select#user_type option").each(function() {
                $("ul#nav_tab li#company_information_tab").remove();
                if ($(this).is(':selected')) {
                    if (this.value != 1) {
                        $("ul#nav_tab").append(
                            '<li class="" id="company_information_tab"> <a href="#company_information" data-toggle="tab"> <span class="">Şirkət məlumatları</span> </a> </li>'
                        );
                    }
                }
            });
        </script>
    @endif
    {{-- Select --}}

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
    @include('layouts.ckeditor.ckeditorService', [
        'uploadUrl' => route('ckEditorUpload'),
        'editors' => ['company_az_description', 'company_ru_description', 'company_en_description'],
    ])

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
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
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
                                                        <option value="3"
                                                            @if (isset($data) && !empty($data) && $data->type == 3) selected @endif>Şirkət
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

                                                        <div class="col-sm-6 col-md-6 col-lg-8">
                                                            <div class="form-group">
                                                                <label for="">Şirkət açıqlaması</label>
                                                                <textarea type="text" placeholder="Şirkət açıqlaması daxil edin..." class="form-control company_az_description"
                                                                style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;"
                                                                    name="company_az_description">{{ isset($data) && !empty($data) && $data->additionalinfo->company_description != null && isset($data->additionalinfo->company_description['az_description']) ? $data->additionalinfo->company_description['az_description'] : null }}</textarea>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        

                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="ru">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="">Название компании</label>
                                                                <input type="text"
                                                                    value="{{ isset($data) && !empty($data) && $data->additionalinfo->company_name != null && isset($data->additionalinfo->company_name['ru_name']) ? $data->additionalinfo->company_name['ru_name'] : null }}"
                                                                    placeholder="Введите название компании..."
                                                                    class="form-control" name="company_ru_name">
                                                                <br>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 col-md-6 col-lg-8">
                                                            <div class="form-group">
                                                                <label for="">Раскрытие информации о компании</label>
                                                                <textarea type="text" placeholder="Введите выписку о компании..." class="form-control company_ru_description"
                                                                style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;"
                                                                    name="company_ru_description">{{ isset($data) && !empty($data) && $data->additionalinfo->company_description != null && isset($data->additionalinfo->company_description['ru_description']) ? $data->additionalinfo->company_description['ru_description'] : null }}</textarea>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        

                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="en">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="">Company name</label>
                                                                <input type="text"
                                                                    value="{{ isset($data) && !empty($data) && $data->additionalinfo->company_name != null && isset($data->additionalinfo->company_name['en_name']) ? $data->additionalinfo->company_name['en_name'] : null }}"
                                                                    placeholder="Enter the company name..."
                                                                    class="form-control" name="company_en_name">
                                                                <br>
                                                            </div>
                                                        </div>
                                                      
                                                        <div class="col-sm-6 col-md-6 col-lg-8">
                                                            <div class="form-group">
                                                                <label for="">Company disclosure</label>
                                                                <textarea type="text" placeholder="Enter a company statement..." class="form-control company_en_description"
                                                                style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;"
                                                                    name="company_en_description">{{ isset($data) && !empty($data) && $data->additionalinfo->company_description != null && isset($data->additionalinfo->company_description['en_description']) ? $data->additionalinfo->company_description['en_description'] : null }}</textarea>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6 col-md-6 col-lg-4">
                                                @if (isset($data) && isset($data->additionalinfo->company_image) && !empty($data->additionalinfo->company_image))
                                                    <img src="{{ asset('/uploads/users/' . $data->additionalinfo->company_image) }}"
                                                        class="img-fluid img-responsive"
                                                         />
                                                @endif
                                                <div class="form-group">
                                                    <label for="">Şirkət profil şəkli</label>
                                                    <input type="file" class="form-control"
                                                        name="company_image">
                                                    <br>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <br>

                                    <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-primary">Təsdiq et</button>
                                            <a type="button" href="{{ route('users.index') }}" class="btn">Ləğv
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
