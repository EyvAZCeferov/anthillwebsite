@extends('layouts.app')
@section('menu_users', 'open')
@section('title')
    @if (isset($data) && !empty($data) && isset($data->name_surname) && !empty($data->name_surname))
        {{ $data->name_surname }}
    @else
        @lang('additional.urls.user')
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
                    '<li class="" id="company_information_tab"> <a href="#company_information" data-toggle="tab"> <span class="">@lang('additional.urls.freelancer') @lang('additional.page_types.info')</span> </a> </li>'
                );
            }

        });

        $(function() {
            if ($("select#user_type").val() != 1) {
                $("ul#nav_tab").append(
                    '<li class="" id="company_information_tab"> <a href="#company_information" data-toggle="tab"> <span class="">@lang('additional.urls.freelancer') @lang('additional.page_types.info')</span> </a> </li>'
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
                            '<li class="" id="company_information_tab"> <a href="#company_information" data-toggle="tab"> <span class="">@lang('additional.urls.freelancer') @lang('additional.page_types.info')</span> </a> </li>'
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
        'editors' => ['company_en_description'],
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
                                @lang('additional.urls.user') @lang('additional.page_types.update')
                            @else
                                @lang('additional.urls.user') @lang('additional.page_types.create')
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
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang('additional.urls.dashboard')</a>
                            </li>
                            <li>
                                <a href="{{ route('users.index') }}">@lang('additional.urls.user')</a>
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
                                                <span class="">@lang('additional.general.personal') @lang('additional.page_types.info')</span>
                                            </a>
                                        </li>
                                        @if (isset($data) && !empty($data) && $data->type != 1)
                                            <li class="" id="company_information_tab">
                                                <a href="#company_information" data-toggle="tab">
                                                    <span class="">@lang('additional.urls.freelancer') @lang('additional.page_types.info')</span>
                                                </a>
                                            </li>
                                        @endif

                                    </ul>

                                    <div class="tab-content primary">

                                        <div class="tab-pane fade in active" id="personal_information">
                                            <br>
                                            <div class="row px-5">
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <label for="">@lang('additional.forms.name_surname')</label>
                                                    <input type="text"
                                                        value="{{ isset($data) && !empty($data) && $data->name_surname != null ? $data->name_surname : null }}"
                                                        placeholder="@lang('additional.forms.name_surname')" class="form-control"
                                                        name="name_surname">
                                                    <br>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <label for="">@lang('additional.forms.email') </label>
                                                    <input type="text"
                                                        value="{{ isset($data) && !empty($data) && $data->email != null ? $data->email : null }}"
                                                        placeholder="@lang('additional.forms.email')" class="form-control"
                                                        name="email">
                                                    <br>
                                                </div>
                                                {{-- <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <label for="">@lang('additional.forms.main_phone')</label>

                                                    <input type="text"
                                                        value="{{ isset($data) && !empty($data) && $data->phone != null ? $data->phone : null }}"
                                                        placeholder="@lang('additional.forms.main_phone')" class="form-control"
                                                        name="phone">
                                                    <br>
                                                </div> --}}
                                                {{-- <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <label for="">@lang('additional.forms.additional_phone')</label>

                                                    <input type="text"
                                                        value="{{ isset($data) && !empty($data) && $data->phone_2 != null ? $data->phone_2 : null }}"
                                                        placeholder="@lang('additional.forms.additional_phone')" class="form-control"
                                                        name="phone_2">
                                                    <br>
                                                </div> --}}

                                                @if (isset($data) &&
                                                        !empty($data) &&
                                                        auth()->check() &&
                                                        auth()->user()->hasRole('Admin'))
                                                    <div class="col-sm-6 col-md-6 col-lg-4">
                                                        <label for="">@lang('additional.forms.original_password')</label>

                                                        <input type="text"
                                                            value="{{ isset($data) && !empty($data) && $data->additionalinfo->original_pass != null ? $data->additionalinfo->original_pass : null }}"
                                                            placeholder="@lang('additional.forms.original_password')" class="form-control"
                                                            name="original_pass">
                                                        <br>
                                                    </div>
                                                @endif

                                                @if (isset($data) && !empty($data))
                                                    <div class="col-sm-6 col-md-6 col-lg-4">
                                                        <label for="">@lang('additional.forms.new_password')</label>

                                                        <input type="password" placeholder="@lang('additional.forms.new_password')"
                                                            class="form-control" name="password">
                                                        <br>
                                                    </div>
                                                @endif

                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <label for="">@lang('additional.forms.type')</label>

                                                    <select name="type" class="form-control" id="user_type">
                                                        @if (!isset($data) && empty($data))
                                                            <option value=""></option>
                                                        @endif
                                                        <option value="1"
                                                            @if (isset($data) && !empty($data) && $data->type == 1) selected @endif>
                                                            @lang('additional.urls.user')</option>
                                                        <option value="3"
                                                            @if (isset($data) && !empty($data) && $data->type == 3) selected @endif>
                                                            @lang('additional.urls.freelancer')
                                                        </option>

                                                    </select>
                                                    <br>
                                                </div>
                                            </div>
                                            <br>

                                        </div>

                                        <div class="tab-pane fade in" id="company_information">


                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="">@lang('additional.forms.name')</label>
                                                        <input type="text"
                                                            value="{{ isset($data) && !empty($data) && $data->additionalinfo->company_name != null && isset($data->additionalinfo->company_name['en_name']) ? $data->additionalinfo->company_name['en_name'] : null }}"
                                                            placeholder="" class="form-control" name="company_en_name">
                                                        <br>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-6 col-lg-8">
                                                    <div class="form-group">
                                                        <label for="">@lang('additional.forms.description')</label>
                                                        <textarea type="text" class="form-control company_en_description"
                                                            style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;"
                                                            name="company_en_description">{{ isset($data) && !empty($data) && $data->additionalinfo->company_description != null && isset($data->additionalinfo->company_description['en_description']) ? $data->additionalinfo->company_description['en_description'] : null }}</textarea>
                                                        <br>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                        

                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                            @if (isset($data) && isset($data->additionalinfo->company_image) && !empty($data->additionalinfo->company_image))
                                                <img src="{{ asset('/uploads/users/' . $data->additionalinfo->company_image) }}"
                                                    class="img-fluid img-responsive" />
                                            @endif
                                            <div class="form-group">
                                                <label for="">@lang("additional.forms.image")</label>
                                                <input type="file" class="form-control" name="company_image">
                                                <br>
                                            </div>
                                        </div>
                                    </div>


                                    <br>

                                    <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-primary">@lang('additional.buttons.submit')</button>
                                            <a type="button" href="{{ route('users.index') }}" class="btn">@lang("additional.buttons.cancel")</a>
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
