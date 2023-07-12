@extends('layouts.app')
@section('title')
    @if (isset($data) && !empty($data))
        {{ $data->name[app()->getLocale() . '_name'] }} -- {{ $data->code }}
    @else
        @lang('additional.urls.addservice')
    @endif
@endsection
@section('addservice_menu', 'active')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
@endpush

@section('content')
    @include('auth.left_profile_tab')
    <section>
        <div class="container">
            <div class="row profile_heaader">
                <h1 class="w-100 text-center">
                    @if (isset($data) && !empty($data))
                        @lang('additional.urls.editservice')
                    @else
                        @lang('additional.urls.addservice')
                    @endif
                </h1>
            </div>
        </div>
        <div class="container">
            <div class="row margin-y-10">
                <form class="margin-y-40 margin-mobile-y-10" onsubmit="formsend()" id="formsend">
                    <div id="messages" enctype="multipart/form-data"></div>
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}" />
                    <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
                    @if (isset($data) && !empty($data))
                        <input type="hidden" name="code" value="{{ $data->code }}">
                    @endif
                    <div class="row add_service_row">
                        <div class="column column-30">
                            <p class="label_left">@lang('additional.forms.servicename')<span class="required">*</span> </p>
                        </div>
                        <div class="column column-70">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="@lang('additional.forms.servicename')"
                                    @if (isset($data) && isset($data->name) && !empty($data->name)) value="{{ $data->name['az_name'] }}" @endif>
                            </div>
                        </div>
                    </div>
                    <div class="row add_service_row">
                        <div class="column column-30">
                            <p class="label_left">@lang('additional.pages.auth.category')<span class="required">*</span> </p>
                        </div>
                        <div class="column column-70">
                            <div class="form-group">
                                <select name="category_id" class="form-control" onchange="change_category(event)">
                                    <option value="">@lang('additional.forms.selectcategory')</option>
                                    @foreach (categories() as $category)
                                        <option value="{{ $category->id }}"
                                            @if (isset($data) && isset($data->category_id) && !empty($data->category_id) && $data->category_id == $category->id) selected @endif>
                                            {{ $category->name[app()->getLocale() . '_name'] }}</option>
                                        @foreach ($category->alt_categoryes as $alt_cat)
                                            <option value="{{ $alt_cat->id }}"
                                                @if (isset($data) && isset($data->category_id) && !empty($data->category_id) && $data->category_id == $alt_cat->id) selected @endif>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $alt_cat->name[app()->getLocale() . '_name'] }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row add_service_row">
                        <div class="column column-30">
                            <p class="label_left">@lang('additional.forms.price')<span class="required">*</span></p>
                        </div>
                        <div class="column column-70">
                            <div class="form-group ">
                                <input type="text" class="form-control" name="price" placeholder="@lang('additional.forms.price')"
                                    @if (isset($data) && isset($data->price) && !empty($data->price)) value="{{ $data->price }}" @endif>
                                <span class="eye-icon">€</span>
                            </div>
                        </div>
                    </div>
                    <div id="attributes">
                        @if (isset($data) && !empty($data))
                            @if (!empty($data->attributes))
                                @php($previousGroupId = null)
                                @foreach ($data->attributes as $attributeEl)
                                    @php($group = $attributeEl->attributegroup)
                                    @php($attribute = $attributeEl->attribute)
                                    @if (!empty($attribute) && isset($attribute->name['az_name']) && trim($attribute->name['az_name']) != null)
                                        @if ($previousGroupId !== $attributeEl->attribute_group_id)
                                            <div class="row add_service_row" id="attributerow_{{ $group->id }}">
                                                <div class="column column-30">
                                                    <p class="label_left">{{ $group->name[app()->getLocale() . '_name'] }}
                                                    </p>
                                                </div>
                                                @if ($group->datatype == 'integer')
                                                    <div class="column column-50">
                                                        <div class="form-group"><input type="number" class="form-control"
                                                                name="attribute[{{ $group->id }}]"
                                                                value="{{ $attribute->name[app()->getLocale() . '_name'] }}" />
                                                        </div>
                                                    </div>
                                                @elseif($group->datatype == 'string')
                                                    <div class="column column-50">
                                                        <div class="form-group"><input type="text" class="form-control"
                                                                name="attribute[{{ $group->id }}]"
                                                                value="{{ $attribute->name[app()->getLocale() . '_name'] }}" />
                                                        </div>
                                                    </div>
                                                @elseif($group->datatype == 'boolean')
                                                    <div class="column column-50">
                                                        <div class="form-group"><select
                                                                name="attribute[{{ $group->id }}]"
                                                                id="attribute_group_{{ $group->id }}"
                                                                class="form-control">
                                                                <option value=""></option>
                                                                @foreach ($group->groupElements as $grel)
                                                                    <option value="{{ $grel->id }}"
                                                                        @if ($grel->id == $attribute->id) selected @endif>
                                                                        {{ $grEl->name[app()->getLocale() . '_name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @elseif($group->datatype == 'price')
                                                    <div class="column column-50">
                                                        <div class="form-group"><input type="text" class="form-control"
                                                                name="attribute[{{ $group->id }}]"
                                                                value="{{ $attribute->name[app()->getLocale() . '_name'] }}" /><span
                                                                class="eye-icon" id="password-eye-icon">€</span></div>
                                                    </div>
                                                @endif
                                                <div class="column column-20 delete_attribute_area">
                                                    <button type="button"
                                                        onclick="delete_attribute(`{{ $group->id }}`,`{{ $data->id }}`)"
                                                        class="btn btn-danger delete_attribute"><i
                                                            class="las la-trash"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                        @php($previousGroupId = $attributeEl->attribute_group_id)
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    </div>
                    <div class="row add_service_row">
                        <div class="column column-30">
                            <p class="label_left">@lang('additional.forms.additionalinfo')<span class="required">*</span></p>
                        </div>
                        <div class="column column-70">
                            <div class="form-group height-auto">
                                <textarea rows="10" name="additional_info" class="form-control" placeholder="@lang('additional.forms.enteradditionalinfo')">
@if (isset($data) && isset($data->description) && !empty($data->description))
{{ App\Helpers\Helper::strip_tags_with_whitespace($data->description['az_description']) }}
@endif
</textarea>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row add_service_row">
                    <div class="column column-30">
                        <p class="label_left">@lang('additional.forms.images')<span class="required">*</span></p>
                    </div>
                    <div class="column column-70">
                        <div class="form-group height-auto addnewimage_area">
                            <form action="{{ route('api.imageuploadproduct', ['token' => $token]) }}" method="post">
                                <div id="mydropzone" class="dropzone"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button class="submit" id="formsendbutton" form='formsend' type="submit">
                        @if (isset($data) && !empty($data))
                            @lang('additional.buttons.update')
                        @else
                            @lang('additional.buttons.add')
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
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
            dictDefaultMessage: '<i class="las la-camera"></i><span>@lang('additional.forms.addnewimage')</span>',
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
                        url: "{{ route('api.changeorder', ['token' => $token]) }}",
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
    @if (isset($data) && !empty($data))
        <script>
            $(function() {
                var value = $("select[name=category_id]").val();
                var event = {
                    target: {
                        value
                    }
                };
                change_category(event, 'isset');
            });
        </script>
    @endif
    <script>
        function change_category(event, isset = null) {
            var attributesDiv = document.getElementById("attributes");
            // Hide the div element and clear its content
            if (isset == null) {
                attributesDiv.style.display = "none";
                attributesDiv.innerHTML = "";
            }
            getAttributes(event.target.value).then((data) => {
                if (data != null && data.length > 0) {
                    attributesDiv.style.display = "block";

                    data.forEach((item) => {
                        var lang = '{{ app()->getLocale() }}';
                        var group_name;
                        var selected_attribute;

                        if (lang == 'az') {
                            group_name = item.attribute_group.name.az_name;
                        } else if (lang == 'ru') {
                            group_name = item.attribute_group.name.ru_name;
                        } else if (lang == 'en') {
                            group_name = item.attribute_group.name.en_name;
                        } else if (lang == 'tr') {
                            group_name = item.attribute_group.name.tr_name;
                        } else {
                            group_name = item.attribute_group.name.tr_name;
                        }
                        @if (isset($data) && !empty($data))
                            var url =
                                `/api/get_category_datas/{{ $token }}/${item.attribute_group.id}`;
                            $.ajax({
                                url,
                                type: "GET",
                                success: function(data) {
                                    let selected_data = data;
                                    if (selected_data != null && selected_data.id > 0) {
                                        createattribute(attributesDiv, item, group_name,
                                            selected_data);
                                    } else {
                                        createattribute(attributesDiv, item, group_name, []);
                                    }
                                },
                            });
                        @else
                            createattribute(attributesDiv, item, group_name, []);
                        @endif
                    });
                }
            });
        }

        function createattribute(attributesDiv, item, group_name, selected_attribute) {
            if (item.attribute_group.datatype == "integer") {
                var element =
                    `<div class="column column-70"><div class="form-group"><input type="number" class="form-control" name="attribute[${item.attribute_group.id}]" value="${selected_attribute.id>0 && selected_attribute!=null ? selected_attribute.name.az_name : ''}" /></div></div>`;
            } else if (item.attribute_group.datatype == "string") {
                var element =
                    `<div class="column column-70"><div class="form-group"><input type="text" class="form-control" name="attribute[${item.attribute_group.id}]" value="${selected_attribute.id>0 && selected_attribute!=null ? selected_attribute.name.az_name : ''}" /></div></div>`;
            } else if (item.attribute_group.datatype == "price") {
                var element =
                    `<div class="column column-70"><div class="form-group"><input type="text" class="form-control" name="attribute[${item.attribute_group.id}]" value="${selected_attribute.id>0 && selected_attribute!=null ? selected_attribute.name.az_name : ''}" /><span class="eye-icon" id="password-eye-icon">€</span></div></div>`;
            } else if (item.attribute_group.datatype == "boolean") {
                var element =
                    `<div class="column column-70"><div class="form-group"><select name="attribute[${item.attribute_group.id}]" id="attribute_group_${item.attribute_group.id}" class="form-control">`;
                $.each(item.attribute_group.group_elements,
                    function(
                        index, item_a) {
                        var lang = '{{ app()->getLocale() }}';
                        if (lang == 'az') {
                            var item_2 =
                                `<option ${selected_attribute.id>0 && selected_attribute!=null && selected_attribute.name.az_name==item_a.name.az_name ? 'selected' : ''} value='${item_a.name.az_name}'>${item_a.name.az_name}</option> `;
                        } else if (lang == 'ru') {
                            var item_2 =
                                `<option ${selected_attribute.id>0 && selected_attribute!=null && selected_attribute.name.ru_name==item_a.name.ru_name ? 'selected' : ''} value='${item_a.name.az_name}'>${item_a.name.ru_name}</option> `;
                        } else if (lang == 'en') {
                            var item_2 =
                                `<option ${selected_attribute.id>0 && selected_attribute!=null && selected_attribute.name.en_name==item_a.name.en_name ? 'selected' : ''} value='${item_a.name.az_name}'>${item_a.name.en_name}</option> `;
                        } else if (lang == 'tr') {
                            var item_2 =
                                `<option ${selected_attribute.id>0 && selected_attribute!=null && selected_attribute.name.tr_name==item_a.name.tr_name ? 'selected' : ''} value='${item_a.name.az_name}'>${item_a.name.tr_name}</option> `;
                        } else {
                            var item_2 =
                                `<option ${selected_attribute.id>0 && selected_attribute!=null && selected_attribute.name.az_name==item_a.name.az_name ? 'selected' : ''} value='${item_a.name.az_name}'>${item_a.name.az_name}</option> `;
                        }

                        element = element + item_2;

                    });
                element = element + `</select></div></div>`;
            }
            var item =
                `<div class="row add_service_row"><div class="column column-30"><p class="label_left">${group_name}</p></div>${element}</div>`;
            attributesDiv.innerHTML += item;
        }
    </script>
    <script>
        function getAttributes(category_id) {
            return new Promise((resolve, reject) => {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('api.get_attributes') }}');
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        resolve(JSON.parse(xhr.responseText));
                    } else {
                        reject(xhr.statusText);
                    }
                };
                xhr.onerror = function() {
                    reject(xhr.statusText);
                };
                xhr.send(JSON.stringify({
                    category_id
                }));
            });
        }
    </script>
    <script>
        $(function() {
            var buttonsendform = $("button#formsendbutton");
            buttonsendform.prop('disabled', true);
            setInterval(function() {
                if (
                    $("input[name=name]").val() != null &&
                    $("input[name=name]").val().length > 0 &&
                    $("select[name=category_id]").val() != null &&
                    $("select[name=category_id]").val().length > 0 &&
                    $("input[name=price]").val() != null &&
                    $("input[name=price]").val().length > 0 &&
                    $("textarea[name=additional_info]").val() != null &&
                    $("textarea[name=additional_info]").val().length > 0 &&
                    $(".preview-image").length > 0 &&
                    $(".preview-container .loader.active").length == 0
                ) {
                    buttonsendform.prop('disabled', false);
                } else {
                    buttonsendform.prop('disabled', true);
                }
            }, 1000);
        });
    </script>
    <script>
        function formsend() {
            event.preventDefault();
            showLoader();
            $("ul.image_errors li.image_error").css('display', 'none');
            var formData = new FormData(document.getElementById('formsend'));
            $("#loadbeforeajax").css('display', 'flex');
            var buttonsendform = $("button#formsendbutton");
            $.ajax({
                url: "@if (!isset($data) && empty($data)) {{ route('addnew.form') }} @else {{ route('updatenew.form') }} @endif ",
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                success: function(data) {
                    hideLoader();
                    $("#loadbeforeajax").css('display', 'none');
                    buttonsendform.prop('disabled', false);
                    if (data.status == "success") {
                        window.location.href = data.url;
                    } else {
                        buttonsendform.prop('disabled', true);
                        createalert(data.status, data.message, 'formsend');
                    }
                },
                error: function(data) {
                    hideLoader();
                    $("#loadbeforeajax").css('display', 'none');
                    buttonsendform.prop('disabled', true);
                    createalert(data.status, data.message, 'formsend');
                }
            });
        }
    </script>
    @if (isset($data) && !empty($data))
        <script defer>
            function delete_attribute(id, product_id) {
                event.preventDefault();
                showLoader();
                var formData = {
                    group_id: id,
                    product_id
                };

                $.ajax({
                    url: "{{ route('attributes.delete') }}",
                    data: formData,
                    type: 'post',
                    success: function(data) {
                        hideLoader();
                        createalert(data.status, data.message, 'formsend');
                    },
                    error: function(data) {
                        hideLoader();
                        createalert(data.status, data.message, 'formsend');
                    }
                });

                $(`#attributerow_${id}`).remove();

            }
        </script>
    @endif
@endpush
