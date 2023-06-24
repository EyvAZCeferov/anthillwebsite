@extends('layouts.app')
@section('menu_products', 'open')
@section('title')
    @if (isset($data) && $data != null)
        @lang("additional.urls.service") @lang("additional.page_types.update")
    @else
        @lang("additional.urls.service") @lang("additional.page_types.create")
    @endif
@endsection
@section('content')

@section('css')

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
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
    <meta name="_token" content="{{ csrf_token() }}">
    <style>
        div#city_area {
            display: none;
        }

        div#district_area {
            display: none;
        }

        div#village_area {
            display: none;
        }

        #cancel_reason_input {
            display: none;
        }
    </style>

    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.24/r-2.2.7/rr-1.2.7/datatables.min.css" />
    <style>
        .image_one {
            position: relative;
            margin-bottom: 1.1em;
            height: 300px;
            overflow: hidden;
        }

        .image_one .imagebuttons {
            position: absolute;
            top: 0;
            left: 5%;
            width: 100%;
        }

        .image_one img {
            width: 100%;
            height: 100%;
            object-fit: fill;
        }

        .loader_image {
            display: none;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .2);
            align-content: center;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .loader_image.active {
            display: flex;
        }

        .loader_image img {
            object-fit: contain;
            width: 70%;
            height: 70%;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
    <style>
        #mydropzone {
            width: 100%;
            border: 1px dashed #3e5daa;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            align-content: center;
            flex-wrap: wrap;
            z-index: 0;
            border-radius: 15px;
            margin: 0 auto;
        }

        #mydropzone .dz-message {
            width: 120px;
            height: 100px;
            background-color: #3e5daa;
            color: #fff;
            display: flex !important;
            flex-direction: column;
            align-items: center;
            align-content: center;
            justify-content: center;
            border-radius: 15px;
            z-index: 1;
            margin: 5px;
            margin-bottom: 10px;
        }

        #mydropzone .dz-message .dz-button {
            display: flex;
            flex-direction: column;
            padding: 10px 15px;
            justify-content: space-between;
            color: #fff;
            font-size: 14px;
            align-items: center;
            align-content: center;
            margin-bottom: 10px;
        }

        #mydropzone .dz-message .dz-button i {
            font-size: 35px;
            display: block;
            margin-bottom: 5px;
        }

        #mydropzone .dz-message .dz-button span {
            text-decoration: underline;
            font-size: 14px;
        }

        #mydropzone .preview-container {
            width: 120px;
            height: 100px;
            margin-right: 5px;
            margin-bottom: 10px;
            padding: 0;
            background-color: transparent;
            line-height: 100px;
            position: relative;
            flex-direction: column;
            z-index: 12;
            transition: all 0.6s;
        }

        #mydropzone .preview-container:hover,
        #mydropzone .preview-container:focus,
        #mydropzone .preview-container:active {
            cursor: all-scroll;
        }

        #mydropzone .preview-container .loader {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            align-items: center;
            align-content: center;
            text-align: center;
            justify-content: center;
            display: none;
            border-radius: 20px;
            background-color: #67c347;
        }

        #mydropzone .preview-container .loader img {
            width: 50%;
            height: 50%;
            object-fit: contain;
        }

        #mydropzone .preview-container .loader.active {
            display: flex;
            background-color: #3e5daa;
        }

        #mydropzone .preview-container .preview-image {
            width: 100%;
            height: 100%;
            cursor: all-scroll;
            transition: all ease 0.6s;
        }

        #mydropzone .preview-container .preview-image:hover,
        #mydropzone .preview-container .preview-image:focus,
        #mydropzone .preview-container .preview-image:active {
            cursor: all-scroll;
        }

        #mydropzone .preview-container img.dz-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #mydropzone .preview-container .preview-actions {
            display: none;
            flex-direction: row;
            justify-content: flex-end;
            top: 0;
            right: 0;
            width: 100%;
            height: 30px;
            position: absolute;
        }

        #mydropzone .preview-container .preview-actions.active {
            display: flex;
        }

        #mydropzone .preview-container .preview-actions.active button {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            align-content: center;
            justify-content: center;
            text-align: center;
            font-size: 18px;
            outline: none;
            transition: all ease 0.5s;
            border: none;
            color: #fff;
            background-color: #000;
        }

        #mydropzone .preview-container .preview-actions.active button:hover,
        #mydropzone .preview-container .preview-actions.active button:focus,
        #mydropzone .preview-container .preview-actions.active button:active {
            cursor: pointer;
        }

        #mydropzone .preview-container .preview-actions.active button::-moz-focus-inner {
            border: 0;
        }

        #mydropzone .preview-container .preview-actions.active button.remove-button:focus,
        #mydropzone .preview-container .preview-actions.active button.remove-button:active,
        #mydropzone .preview-container .preview-actions.active button.remove-button:hover {
            background-color: #dc3545;
            cursor: pointer;
        }
    </style>
@endsection
@section('javascript')
    @include('layouts.seo.createseoscript')
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.24/r-2.2.7/rr-1.2.7/datatables.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>


    @include('layouts.ckeditor.ckeditorService', [
        'uploadUrl' => route('ckEditorUpload'),
        'editors' => ['en_description'],
    ])
    {{-- @include('layouts.seo.createseoscript') --}}
    <script src="{{ asset('assets/plugins/tagsinput/js/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>


    @if (isset($data) && !empty($data))
        <script>
            function rotate(button, img, type) {
                event.preventDefault();
                button.disabled = true;
                $(`#image_${img} .loader_image`).addClass("active");
                $.ajax({
                    url: "{{ route('api.rotateproduct', ['code' => isset($data) && !empty($data) ? $data->code : $codeofproduct]) }}",
                    type: "POST",
                    data: {
                        img: img,
                        type: type,
                    },
                    success: function(data) {
                        $(`#image_${img} .loader_image`).removeClass('active');
                        $(`#image_${img} img`).attr('src', data);
                        $(`#image_${img} img`).prop('src', data);
                        setTimeout(() => {
                            button.disabled = false;
                        }, 6000);
                    },
                });
            }
        </script>
    @endif

    <script>
        // Type Of Action
        function delete_image(image) {
            var token = $("input[name='_token']").val();

            var posting = $.ajax({
                url: '{{ route('products.delete_image') }}',
                dataType: 'json',
                data: {
                    image: image,
                    product_id: {{ isset($data) && !empty($data) ? $data->id : 0 }},
                    _token: token
                },
                type: 'post',
                success: function(data) {
                    if (data == 1) {
                        toastr.success(trans("additional.messages.deleted"));
                        $(`div#image_${image}`).remove();
                    } else {
                        toastr.error(trans("additional.messages.tryagain"));
                    }
                },
                error: function(data) {
                    if (data == 0) {
                        toastr.error(trans("additional.messages.tryagain"));
                    } else {
                        toastr.success(trans("additional.messages.deleted"));
                        $(`div#image_${image}`).remove();

                    }
                }
            });
        }
    </script>


    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#user_announcements').DataTable({
                    responsive: true,
                    "ordering": false,
                    "info": true,
                    "scrollCollapse": true,
                });
            }, 500);

            setTimeout(function() {
                $('#category_announcements').DataTable({
                    responsive: true,
                    "ordering": false,
                    "info": true,
                    "scrollCollapse": true,
                });
            }, 500);
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {

            $('[data-fancybox]').fancybox({
                // Options will go here
                buttons: [
                    'close'
                ],
                wheel: false,
                transitionEffect: "slide",
                // thumbs          : false,
                // hash            : false,
                loop: true,
                // keyboard        : true,
                toolbar: false,
                animationEffect: true,
                // arrows          : true,
                clickContent: false
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-ui/smoothness/jquery-ui.min.js') }}"></script>
    <script>
        $(function() {
            var $sortable = $("#img_sortableand_delete").sortable({
                stop: function(event, ui) {
                    var data = $(this).sortable('toArray');
                    $("#images .imgs").remove();
                    $("#images").append(`<span class="imgs">${data.toString()}</span>`);
                    $.ajax({
                        url: "{{ route('api.changeorder', ['code' => isset($data) && !empty($data) ? $data->code : $codeofproduct]) }}",
                        type: "POST",
                        data: {
                            data
                        },
                        success: function(data) {
                            // $("#images").append(`<div class="imgs">${data.toString()}</div>`);
                            toastr.success(trans("additional.messages.order"));
                        },
                        error: function(response) {
                            // $("#images").append(`<div class="imgs">${response.toString()}</div>`);
                            toastr.success(trans("additioanl.messages.tryagain"));
                        }
                    });
                }
            });
            // $sortable.disableSelection();
        });
    </script>


    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"
        integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script>
        // Dropzone konfiqurasiyası
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#mydropzone", {
            url: "{{ route('api.imageuploadproduct', ['token' => $token]) }}",
            autoProcessQueue: true,
            maxFiles: 30,
            dictDefaultMessage: '<i class="las la-camera"></i><span>@lang("additional.page_types.create")</span>',
            acceptedFiles: 'image/*',
            thumbnailMethod: 'crop',
            addRemoveLinks: false,
            previewTemplate: `<div class="preview-container ui-state-default" >
<div class='loader active'>
    <img draggable="false" src="https://upload.wikimedia.org/wikipedia/commons/7/7a/Ajax_loader_metal_512.gif?20180219130538" /></div>

<div class="preview-image">
<img draggable="false" data-dz-thumbnail class="dz-image">
</div>
<div class="preview-actions">
    <button class="remove-button" type="button" data-dz-remove ><i class="las la-trash"></i></button>

</div>
</div>
`,
            init: function() {
                var thisdropzone = this;
                @if (isset($data) && !empty($data))
                    $.ajax({
                        url: "{{ route('api.uploaded_images', ['token' => $token]) }}",
                        type: "GET",
                        success: function(data) {
                            $.each(data, function(key, value) {
                                var mockFile = {
                                    name: value.name,
                                    size: value.size,
                                };
                                var filenameWithoutExtension = getFilenameWithoutExtension(
                                    value
                                    .name);
                                mockFile.upload = {
                                    filename: filenameWithoutExtension,
                                    ext: value.name.substr(value.name.lastIndexOf('.') +
                                        1),
                                    url: value.path
                                };
                                thisdropzone.emit("addedfile", mockFile);
                                thisdropzone.emit("thumbnail", mockFile, value.path);
                                thisdropzone.emit("complete", mockFile);
                            });
                        },
                    });
                @endif
                // Dropzone-a fayl əlavə olunduqda olay
                this.on("addedfile", function(file) {
                    var preview = file.previewTemplate;
                    $(preview).find('.preview-container').attr('id', file.name);
                    $(preview).find('.preview-container').prop('id', file.name);
                    $(preview).attr('id', file.name);
                    $(preview).prop('id', file.name);
                    $("#mydropzone").sortable('refresh');
                });

                // Dropzone-a fayl silindi vaxtı olay
                this.on("removedfile", function(file) {
                    // Silinən faylın adını və ya ID-sini əldə edin
                    // var prevtemp = file.previewTemplate;
                    // var filename = $(prevtemp).find('.preview-image img').prop('alt');
                    // var fileId = file.upload.uuid;
                    var filename = file.name;
                    var fileId = file.upload.uuid;

                    // Seçilmiş faylın adını və ya ID-sini server tərəfinə göndərin
                    $.ajax({
                        url: "{{ route('api.imagedeleteproduct', ['token' => $token]) }}",
                        type: "DELETE",
                        data: {
                            filename: filename,
                            fileId: fileId
                        },
                        success: function(data) {
                            if (data == false) {
                                myDropzone.addFile(file);
                            }
                        },
                        error: function(response) {
                            myDropzone.addFile(file);
                        }
                    });

                    $("#mydropzone").sortable('refresh');
                });

                // File Yuklenib bitennene sonra
                this.on('complete', function(file) {
                    var preview = file.previewTemplate;
                    $(preview).find('.loader').removeClass('active');
                    $(preview).find('.preview-actions').addClass('active');
                    $("#mydropzone").sortable('refresh');
                });

                this.on('success', function(file, response) {
                    var preview = file.previewTemplate;
                    $(preview).find('.preview-container').attr('id', response);
                    $(preview).find('.preview-container').prop('id', response);
                    $(preview).attr('id', response);
                    $(preview).prop('id', response);
                    $(preview).find('.preview-image img').prop('alt', response);
                    $(preview).find('.preview-image img').attr('alt', response);
                    $(preview).find('.dz-filename span').text(response);
                    var preview = file.previewTemplate;
                    $(preview).find('.preview-container').attr('id', response);
                    $(preview).find('.preview-container').prop('id', response);
                    $(preview).attr('id', response);
                    $(preview).prop('id', response);
                    $(preview).find('.preview-image img').prop('alt', response);
                    $(preview).find('.preview-image img').attr('alt', response);
                    $("#mydropzone").sortable('refresh');
                });
            },

        });
    </script>

    <script>
        function getFilenameWithoutExtension(filename) {
            var dotIndex = filename.lastIndexOf(".");
            if (dotIndex == -1) {
                return filename;
            } else {
                return filename.substr(0, dotIndex);
            }
        }
    </script>

    <script>
        $(function() {
            var $sortable = $("#mydropzone").sortable({
                stop: function(event, ui) {
                    var data = $(this).sortable('toArray');
                    $.ajax({
                        url: "{{ route('api.changeorder', ['code' => isset($data) && !empty($data) ? $data->code : $codeofproduct]) }}",
                        type: "POST",
                        data: {
                            data
                        },
                        success: function(data) {
                            //
                        },
                        error: function(response) {
                            //
                        }
                    });
                }
            });
            // $sortable.disableSelection();
        });
    </script>
@endsection

<section id="main-content" class=" ">
    <section class="wrapper main-wrapper" style=''>

        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">

                <div class="pull-left">
                    <h1 class="title">
                        @if (isset($data) && $data != null)
                            @lang("additional.urls.service") @lang("additional.page_types.update")
                        @else
                            @lang("additional.urls.service") @lang("additional.page_types.create")
                        @endif
                        &nbsp;&nbsp;
                        <span>
                            @include('layouts.topbarbuttons', [
                                'routename' => 'products',
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
                            <a href="{{ route('products.index') }}">@lang("additional.urls.service")</a>
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
                            action="{{ isset($data) && !empty($data) ? route('products.update', $data->id) : route('products.store') }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            @if (isset($data) && !empty($data))
                                @method('PATCH')
                            @endif

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="row">
                                <ul class="nav nav-tabs nav-justified primary">
                                    <li class="active">
                                        <a href="#product_info" data-toggle="tab">
                                            <span class="">@lang("additional.urls.service") @lang("additional.page_types.info")</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#attributes" data-toggle="tab">
                                            <span class="">@lang("additional.urls.attributes")</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#other" data-toggle="tab">
                                            <span class="">@lang("additional.urls.other") @lang("additional.page_types.info")</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#images" data-toggle="tab">
                                            <span class="">@lang("additional.forms.images")</span>
                                        </a>
                                    </li>
                                    @if (isset($data) && !empty($data))
                                        <li class="">
                                            <a href="#userdata" data-toggle="tab">
                                                <span class="">@lang("additional.urls.freelancer")</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>

                                <div class="tab-content primary">

                                    <div class="tab-pane fade in active" id="product_info">
                                        <div class="row">

                                          
                                                <div class="tab-pane fade" id="en">
                                                    <br>
                                                    <input type="text"
                                                        value="{{ isset($data) && !empty($data) && $data->name != null && isset($data->name['en_name']) ? $data->name['en_name'] : null }}"
                                                        placeholder="Enter the name ..." class="form-control"
                                                        name="en_name">
                                                    <br>

                                                    <textarea class="form-control en_description" placeholder="Enter the description ..." name="en_description"
                                                        style="width: 100%; height: 300px; font-size: 14px; line-height: 23px;padding:15px;">
                                                        {!! isset($data) && !empty($data) && $data->description != null && isset($data->description['en_description'])
                                                            ? $data->description['en_description']
                                                            : null !!}</textarea>
                                                    <br>

                                                    @include('layouts.seo.createseo', [
                                                        'langKey' => 'en',
                                                        'data' =>
                                                            isset($data) && !empty($data) ? $data->seo : null,
                                                    ])

                                                </div>

                                            
                                        </div>
                                        <br>
                                    </div>

                                    <div class="tab-pane fade in" id="attributes">

                                        <div id="attributesSection">

                                        </div>

                                        <div class="row">
                                            {{-- @dd($data->attributes) --}}
                                            @foreach ($attributeGroups as $group)
                                                <div class='col-sm-12 col-md-4'
                                                    id='attribute_{{ $group->id }}'>
                                                    <label
                                                        class="form-label">{{ $group->name['en_name'] }}</label>
                                                    @if ($group->datatype == 'integer')
                                                        <div class="controls">
                                                            <input type="number" class="form-control"
                                                                name="attribute[{{ $group->id }}]"
                                                                placeholder=""
                                                                value={{ isset($data) && !empty($data) && $data->attributes->where('attribute_group_id', $group->id)->first() != null ? $data->attributes->where('attribute_group_id', $group->id)->first()->attribute->name['en_name'] : null }}>
                                                        </div>
                                                    @elseif($group->datatype == 'string')
                                                        <div class="controls">
                                                            <input type="text" class="form-control"
                                                                name="attribute[{{ $group->id }}]"
                                                                placeholder=""
                                                                value={{ isset($data) && !empty($data) && $data->attributes->where('attribute_group_id', $group->id)->first() != null ? $data->attributes->where('attribute_group_id', $group->id)->first()->attribute->name['en_name'] : null }}>
                                                        </div>
                                                    @elseif($group->datatype == 'price')
                                                        <div class="controls">
                                                            <input type="number" class="form-control"
                                                                name="attribute[{{ $group->id }}]"
                                                                placeholder=""
                                                                value={{ isset($data) && !empty($data) && $data->attributes->where('attribute_group_id', $group->id)->first() != null ? $data->attributes->where('attribute_group_id', $group->id)->first()->attribute->name['en_name'] : null }}>
                                                        </div>
                                                    @elseif($group->datatype == 'boolean')
                                                        <div class="controls">
                                                            <select name="attribute[{{ $group->id }}]"
                                                                class="form-control">
                                                                <option value="">Seç</option>
                                                                @foreach (App\Models\Attributes::where('group_id', $group->id)->get() as $attribute)
                                                                    <option
                                                                        @if (isset($data) &&
                                                                                !empty($data) &&
                                                                                $data->attributes->where('attribute_group_id', $group->id)->first() != null &&
                                                                                $data->attributes->where('attribute_group_id', $group->id)->first()->attribute->name['en_name'] ==
                                                                                    $attribute->name['en_name']
                                                                        ) selected @endif
                                                                        value="{{ $attribute->name['en_name'] }}">
                                                                        {{ $attribute->name['en_name'] }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    @endif
                                                </div>
                                                <br />
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Other --}}
                                    <div class="tab-pane fade in" id="other">

                                        <div class="row">
                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">@lang("additional.forms.code")</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" name="code"
                                                            required placeholder="CYM***"
                                                            value="{{ isset($data) && $data != null ? $data->code : $codeofproduct }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">@lang("additional.forms.ammount")</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control"
                                                            name="prices[price]" placeholder="0.0"
                                                            value="{{ isset($data) && $data != null && isset($data->price) ? $data->price : null }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label"> @lang("additional.urls.category")</label>
                                                    <div class="controls">
                                                        <select name="category_id" class="form-control">
                                                            <option value="">Bir kateqoriya seçin</option>
                                                            @foreach ($categories as $cat)
                                                                @if (isset($cat->top_id) && $cat->top_id != null && $cat->top_id != 0)
                                                                    <option value="{{ $cat->id }}"
                                                                        @if (isset($data) && isset($data) && !empty($data) && $data->category_id != null && $data->category_id == $cat->id) selected @endif>
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                                        {{ $cat->name['en_name'] }} --
                                                                        {{ $cat->top_category->name['en_name'] }}
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $cat->id }}"
                                                                        @if (isset($data) && isset($data) && !empty($data) && $data->category_id != null && $data->category_id == $cat->id) selected @endif>
                                                                        {{ $cat->name['en_name'] }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label"> @lang("additional.urls.freelancer")</label>
                                                    <div class="controls">
                                                        <select name="user_id" class="form-control">
                                                            <option value=""></option>
                                                            @foreach ($users as $user)
                                                                <option
                                                                    @if (isset($data) && !empty($data) && $data->user_id == $user->id) selected @endif
                                                                    value="{{ $user->id }}">
                                                                    {{ $user->additionalinfo->company_name[app()->getLocale() . '_name'] ?? $user->name_surname }}
                                                                    {{ $user->email }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    {{-- Other --}}

                                    <div class="tab-pane fade in" id="images">

                                        <div class="row">
                                            {{-- <div class="form-group"><label for="">Şəkillər</label><input
                                                    type="file" class="form-control" name="images[]" multiple>
                                            </div> --}}
                                            <div class="form-group height-auto addnewimage_area">
                                                <form
                                                    action="{{ route('api.imageuploadproduct', ['token' => $token]) }}"
                                                    method="post">
                                                    <div id="mydropzone" class="dropzone"></div>
                                                </form>
                                            </div>
                                        </div>
                                        @if (isset($data) && !empty($data))
                                            <div class="row" id="img_sortableand_delete">
                                                @if (empty($data->images))
                                                    <p class="text-center text-danger">@lang("additional.forms.notfound")</p>
                                                @else
                                                    @foreach ($data->images as $image)
                                                        @if (isset($image) && !empty($image))
                                                            <div class="col-sm-6 col-md-4 mr-1 mb-1 image_one"
                                                                style="display:block;"
                                                                id="image_{{ $image->id }}">
                                                                <div class="loader_image"><img
                                                                        src="https://upload.wikimedia.org/wikipedia/commons/7/7a/Ajax_loader_metal_512.gif?20180219130538"
                                                                        alt=""></div>
                                                                <div class="imagebuttons">
                                                                    <button class="btn btn-danger" type="button"
                                                                        onclick="delete_image('{{ $image->id }}')">
                                                                        <i class="fa fa-trash"></i></button>
                                                                    <button class="btn btn-warning"
                                                                        onclick="rotate(this,'{{ $image->id }}','left')"><i
                                                                            class="fa fa-arrow-left"></i></button>
                                                                    <button class="btn btn-warning"
                                                                        onclick="rotate(this,'{{ $image->id }}','right')"><i
                                                                            class="fa fa-arrow-right"></i></button>
                                                                </div>
                                                                @if (isset($image) && !empty($image) && isset($image->original_images))
                                                                    <a href="{{ asset('uploads/products/' . $image->original_images) }}"
                                                                        data-fancybox="group"> <img
                                                                            class="img-fluid img-responsive"
                                                                            src="{{ asset('uploads/products/' . $image->original_images) }}"
                                                                            height="200">
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>


                                        @endif

                                    </div>

                                    {{-- UserData --}}
                                    @if (isset($data) && !empty($data))
                                        <div class="tab-pane fade in" id="userdata">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label">@lang("additional.urls.freelancer")</label>
                                                        <div class="controls">
                                                            <select name="user_id" class="form-control">
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}"
                                                                        @if (isset($data) && !empty($data) && $user->id == $data->user_id) selected @endif>
                                                                        {{ $user->name_surname }} {{ $user->phone }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                @if (isset($user_products) && !empty($user_products))
                                                    <div class="col-lg-12">
                                                        <section class="box ">
                                                            <header class="panel_header">
                                                                <h2 class="title pull-left">@lang("additioanl.urls.freelancer")
                                                                    @lang("additional.urls.service")
                                                                </h2>
                                                                <div class="actions panel_actions pull-right">
                                                                    <i class="box_toggle fa fa-chevron-down"></i>
                                                                    <i class="box_close fa fa-times"></i>
                                                                </div>
                                                            </header>
                                                            <div class="content-body">
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                                                        <!-- ********************************************** -->
                                                                        <table id="user_announcements"
                                                                            class="table table-striped table-bordered"
                                                                            style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>@lang("additionl.forms.image")</th>
                                                                                    <th>@lang('additional.forms.name')</th>
                                                                                    <th>@lang("additional.forms.code")</th>
                                                                                    <th>@lang("additional.forms.ammount")</th>
                                                                                    <th>@lang("additional.urls.category")</th>
                                                                                    <th>@lang("additional.forms.viewcount")</th>
                                                                                </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                                @foreach ($user_products as $dat)
                                                                                    <tr>
                                                                                        <td>
                                                                                            @if (isset($dat) && !empty($dat) && !empty($dat->images->first()) && isset($dat->images->first()->original_images))
                                                                                                <img width="125"
                                                                                                    src="{{ asset('uploads/products/' . $dat->images->first()->original_images) }}">
                                                                                            @endif
                                                                                        </td>

                                                                                        <td>{{ $dat->name['en_name'] ?? null }}
                                                                                        </td>

                                                                                        <td>{{ $dat->code }}</td>

                                                                                        <td>
                                                                                            €
                                                                                            {{ isset($dat->price) ? $dat->price : null }}
                                                                                        <td>
                                                                                            @if ($dat->category_id != null)
                                                                                                <a
                                                                                                    href="{{ url()->current() }}?status={{ $status ?? 'all' }}&category_id={{ $dat->category_id }} ">
                                                                                                    <span
                                                                                                        class="text-info">
                                                                                                        {{ $dat->category->name['en_name'] }}</span></a>
                                                                                            @else
                                                                                                <span
                                                                                                    class="text-danger">Kateqoriya
                                                                                                    yoxdur</span>
                                                                                            @endif
                                                                                        </td>
                                                                                       
                                                                                        <td>{{ count($dat->viewcount) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>

                                                                        </table>
                                                                        <!-- ********************************************** -->

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </div>
                                                @endif
                                                <br>
                                                <br>
                                                @if (isset($category_products) && !empty($category_products))
                                                    <div class="col-lg-12">
                                                        <section class="box ">
                                                            <header class="panel_header">
                                                                <h2 class="title pull-left">@lang("additional.urls.category") @lang("additional.urls.services")
                                                                    @lang("additional.urls.service")
                                                                </h2>
                                                                <div class="actions panel_actions pull-right">
                                                                    <i class="box_toggle fa fa-chevron-down"></i>
                                                                    <i class="box_close fa fa-times"></i>
                                                                </div>
                                                            </header>
                                                            <div class="content-body">
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                                                        <!-- ********************************************** -->
                                                                        <table id="category_announcements"
                                                                            class="table table-striped table-bordered"
                                                                            style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>@lang("additionl.forms.image")</th>
                                                                                    <th>@lang('additional.forms.name')</th>
                                                                                    <th>@lang("additional.forms.code")</th>
                                                                                    <th>@lang("additional.forms.ammount")</th>
                                                                                    <th>@lang("additional.urls.category")</th>
                                                                                    <th>@lang("additional.urls.freelancer")</th>
                                                                                    <th>@lang("additional.forms.viewcount")</th>
                                                                                </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                                @foreach ($category_products as $dat)
                                                                                    <tr>
                                                                                        <td>
                                                                                            @if (isset($dat) && !empty($dat) && !empty($dat->images->first()) && isset($dat->images->first()->original_images))
                                                                                                <img width="125"
                                                                                                    src="{{ asset('uploads/products/' . $dat->images->first()->original_images) }}">
                                                                                            @endif
                                                                                        </td>

                                                                                        <td>{{ $dat->name['en_name'] ?? null }}
                                                                                        </td>

                                                                                        <td>{{ $dat->code }}</td>

                                                                                        <td>
                                                                                            €
                                                                                            {{ isset($dat->price) ? $dat->price : null }}
                                                                                        <td>
                                                                                            @if ($dat->category_id != null)
                                                                                                <a
                                                                                                    href="{{ url()->current() }}?status={{ $status ?? 'all' }}&category_id={{ $dat->category_id }} ">
                                                                                                    <span
                                                                                                        class="text-info">
                                                                                                        {{ $dat->category->name['en_name'] }}</span></a>
                                                                                            @else
                                                                                                <span
                                                                                                    class="text-danger">@lang('additional.forms.notfound')</span>
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>
                                                                                            @if (isset($dat->user) && !empty($dat->user))
                                                                                                <a
                                                                                                    href="{{ url()->current() }}?status={{ $status ?? 'all' }}&user_id={{ $dat->user_id }} ">
                                                                                                    <span
                                                                                                        class="text-info">
                                                                                                        {{ $dat->user->name_surname }}
                                                                                                        {{ $dat->user->phone }}</span></a>
                                                                                            @else
                                                                                                <span
                                                                                                    class="text-danger">@lang('additional.forms.notfound')</span>
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>{{ count($dat->viewcount) }}
                                                                                        </td>

                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>

                                                                        </table>
                                                                        <!-- ********************************************** -->

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </div>
                                                @endif
                                                <br>
                                                <br>
                                            </div>

                                        </div>
                                    @endif
                                    {{-- UserData --}}

                                </div>

                                <br>

                                <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                    <div class="text-left">
                                        <button type="submit" class="btn btn-primary">@lang("additional.buttons.submit")</button>
                                        <a type="button" href="{{ route('products.index') }}" class="btn">Ləğv
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
