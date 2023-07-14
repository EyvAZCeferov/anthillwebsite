@extends('layouts.app')
@section('title')
    @lang('additional.urls.settings') {{ $data->additionalinfo->company_name[app()->getLocale() . '_name'] ?? $data->name_surname }}
@endsection
@section('description')
    {{ App\Helpers\Helper::strip_tags_with_whitespace($data->additionalinfo->company_description[app()->getLocale() . '_description'] ?? null) }}
@endsection
@section('image', App\Helpers\Helper::getImageUrl($data->additionalinfo->company_image, 'users') ?? null)
@section('settings_menu', 'active')
@push('css')
<style>
    .tox-tinymce{
        width:100%;
    }
</style>
@endpush
@section('content')
    @include('auth.left_profile_tab')
    <section>
        <div class="container">
            <div class="row profile_heaader">
                <h1 class="w-100 text-center">@lang('additional.urls.settings')</h1>
            </div>
            <div class="row form_area_settings padding-y-60 padding-x-40 padding-mobile-y-20 padding-mobile-0">
                @if ($data->type == 3)
                    <div class="tabs_sections">
                        <div class="tabs_section profileinformation active"
                            onclick="changetab_settings('profileinformation')">
                            @lang('additional.pages.auth.profileinfo')
                        </div>
                        <div class="tabs_section companyinformation" onclick="changetab_settings('companyinformation')">
                            @if(!empty(lang_properties('companyinfotab','keyword'))) {{ lang_properties('companyinfotab','keyword')->name }} @else  @lang('additional.pages.auth.companyinfo') @endif
                        </div>
                    </div>
                @endif
                <div class="tab_bodyes">
                    <div id="profileinformation" class="tab_body active">
                        <form onsubmit="profileupdate('profileupdate')" method="post" id="profileupdate"
                            style="width:100%;" enctype="multipart/form-data">
                            <div id="messages"></div>
                            @csrf
                            <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                            <input type="hidden" name="type_request" value="profile" />

                            @if ($data->type == 1)
                                <div class="row">
                                    <div class="colum column-100">
                                        <p>@lang('additional.forms.addprofilepicture')</p>
                                        <div class="form-group">
                                            <input type="file" id="company_logo" class="company_logo" name="company_logo" accept="image/*"
                                                onchange="previewImage(event)">
                                            <label for="company_logo" class="company_logo" id="preview">
                                                @if (isset($data) &&
                                                        isset($data->additionalinfo) &&
                                                        !empty($data->additionalinfo) &&
                                                        isset($data->additionalinfo['company_image']) &&
                                                        !empty(trim($data->additionalinfo['company_image'])))
                                                    <img data-src="{{ App\Helpers\Helper::getImageUrl($data->additionalinfo->company_image, 'users') }}"
                                                        alt="{{ $data->name_surname }}" class="lazyload blur-up" />
                                                @else
                                                    <i class="las la-camera-retro"></i>
                                                    @lang('additional.forms.addimage')
                                                @endif

                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endif
                            <div class="row" style="justify-content: space-around">
                                <div class="column column-45">
                                    <div class="form-group">
                                        <label>
                                            @lang('additional.forms.entername_surname')
                                        </label>
                                        <input type="text" name="name_surname" value="{{ $data->name_surname ?? null }}"
                                            placeholder="@lang('additional.forms.entername_surname')" class="form-control">
                                    </div>
                                </div>
                                <div class="column column-45">
                                    <div class="form-group">
                                        <label>
                                            @lang('additional.forms.enteremail')
                                        </label>
                                        <input type="email" name="email" value="{{ $data->email ?? null }}"
                                            placeholder="@lang('additional.forms.enteremail')" class="form-control">
                                    </div>
                                </div>

                                <div class="column column-45">
                                    <div class="form-group">
                                        <label>
                                            @lang('additional.urls.change_password')
                                        </label>
                                        <input type="text" name="old_password" placeholder="@lang('additional.forms.enteroldpassword')"
                                            class="form-control">
                                        <input type="text" name="new_password" placeholder="@lang('additional.forms.enternewpassword')"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <button class="submit" type="submit">@lang('additional.buttons.update')</button>
                            </div>
                        </form>
                    </div>
                    @if ($data->type == 3)
                        <div id="companyinformation" class="tab_body">
                            <form onsubmit="profileupdate('companyupdate')" method="post" id="companyupdate"
                                style="width:100%;" enctype="multipart/form-data">
                                <div id="messages"></div>
                                @csrf
                                <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                                <input type="hidden" name="type_request" value="company" />

                                <div class="row" style="justify-content: space-around">
                                    <div class="colum column-30 mobile_column-100">
                                        <p style="margin:0;margin-bottom:10px;">@lang('additional.forms.addprofilepicture')</p>
                                        <div class="form-group">
                                            <input type="file" id="company_logo" class="company_logo" name="company_logo"
                                                accept="image/*" onchange="previewImage(event)">
                                            <label for="company_logo" class="company_logo" id="preview">
                                                @if (isset($data) &&
                                                        isset($data->additionalinfo) &&
                                                        !empty($data->additionalinfo) &&
                                                        isset($data->additionalinfo['company_image']) &&
                                                        !empty(trim($data->additionalinfo['company_image'])))
                                                    <img src="{{ App\Helpers\Helper::getImageUrl($data->additionalinfo->company_image, 'users') }}"
                                                        alt="{{ $data->name_surname }}" class="lazyload blur-up" />
                                                @else
                                                    <i class="las la-camera-retro"></i>
                                                    @lang('additional.forms.addimage')
                                                @endif

                                            </label>
                                        </div>
                                    </div>
                                    <div class="column column-60 mobile_column-100">
                                        <div class="form-group">
                                            <label>@if(!empty(lang_properties('companydescription','keyword'))) {{ lang_properties('companydescription','keyword')->name }} @else  @lang('additional.forms.company_description') @endif</label>
                                            <textarea rows="8" name="company_description" class="form-control company_description" placeholder="@if(!empty(lang_properties('companydescription','keyword'))) {{ lang_properties('companydescription','keyword')->name }} @else  @lang('additional.forms.company_description') @endif">{!! isset($data->additionalinfo) && !empty($data->additionalinfo) && isset($data->additionalinfo->company_description[app()->getLocale() . '_description']) && !empty($data->additionalinfo->company_description[app()->getLocale() . '_description']) ? $data->additionalinfo->company_description[app()->getLocale() . '_description'] : null !!}</textarea>
                                        </div>

                                    </div>
                                </div>
                                <hr>

                                <div class="row" style="justify-content: space-around">
                                    <div class="column column-45">
                                        <div class="form-group">
                                            <label>
                                                @if(!empty(lang_properties('companyname','keyword'))) {{ lang_properties('companyname','keyword')->name }} @else  @lang('additional.pages.auth.entercompany_name') @endif
                                            </label>
                                            <input type="text" name="company_name"
                                                value="{{ isset($data->additionalinfo) && !empty($data->additionalinfo) && isset($data->additionalinfo->company_name[app()->getLocale() . '_name']) && !empty($data->additionalinfo->company_name[app()->getLocale() . '_name']) ? $data->additionalinfo->company_name[app()->getLocale() . '_name'] : null }}"
                                                placeholder="@if(!empty(lang_properties('companyname','keyword'))) {{ lang_properties('companyname','keyword')->name }} @else  @lang('additional.pages.auth.entercompany_name') @endif" class="form-control">
                                        </div>
                                    </div>



                                </div>
                                <div class="row">
                                    <button class="submit" id="formsendbutton" type="submit">@lang('additional.buttons.update')</button>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <br>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script  src="https://cdn.tiny.cloud/1/0j6r4v4wrpghb7ht8z0yf85cuzcv8iadyrza5gp8f4lxi1ib/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        function profileupdate(id) {
            showLoader();
            event.preventDefault();
            var buttonsendform = $("button#formsendbutton");
            buttonsendform.prop('disabled', true);

            if (id == "companyupdate") {
                var nexprocess = {
                    company_description: false,
                    company_name: false,
                };
            } else {
                var nexprocess = {
                    email: false,
                    name_surname: false,
                };
            }
            var form = $(`form#${id}`)[0];

            var formData = new FormData(form);

            if(tinymce.activeEditor!=null){
                var tinyEditorData = tinymce.activeEditor.getContent();

                formData.append('company_description', tinyEditorData);
            }

            if (id == "companyupdate") {
                if (formData.get("company_name") == null || formData.get("company_name").length == 0) {
                    hideLoader();
                    createalert('error', '@lang('additional.messages.nullcompany_name')', id);
                    nexprocess['company_name'] = false;
                } else {
                    nexprocess['company_name'] = true;
                }

                if (formData.get("company_description") == null || formData.get("company_description").length == 0) {
                    hideLoader();
                    createalert('error', '@lang('additional.messages.nullcompany_description')', id);
                    nexprocess['company_description'] = false;
                } else {
                    nexprocess['company_description'] = true;
                }

                if (nexprocess['company_name'] == true &&
                    nexprocess['company_description'] == true) {
                    $.ajax({
                        url: "{{ route('auth.updatedata') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'post',
                        success: function(data) {
                            hideLoader();
                            $("#loadbeforeajax").css('display', 'none');
                            // buttonsendform.prop('disabled', false);
                            // createalert(data.status, data.message, 'profileupdate');
                            window.location.reload();
                        },
                        error: function(data) {
                            hideLoader();
                            $("#loadbeforeajax").css('display', 'none');
                            // buttonsendform.prop('disabled', false);
                            createalert(data.status, data.message, 'profileupdate');
                        }
                    });
                }

            } else {
                if (formData.get("name_surname") == null || formData.get("name_surname").length == 0) {
                    hideLoader();
                    createalert('error', '@lang('additional.messages.nullname_surname')', id);
                    nexprocess['name_surname'] = false;
                } else {
                    nexprocess['name_surname'] = true;
                }



                if (formData.get("email") == null || formData.get("email").length == 0) {
                    hideLoader();
                    createalert('error', '@lang('additional.messages.nullemail')', id);
                    nexprocess['email'] = false;
                } else {
                    if (!isValidEmail(formData.get("email"))) {
                        hideLoader();
                        createalert('error', '@lang('additional.messages.emailtypeerror')', id);
                        nexprocess['email'] = false;
                    } else {
                        nexprocess['email'] = true;
                    }
                }

                if (nexprocess['email'] == true && nexprocess['name_surname'] == true) {
                    $.ajax({
                        url: "{{ route('auth.updatedata') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'post',
                        success: function(data) {
                            hideLoader();
                            $("#loadbeforeajax").css('display', 'none');
                            // buttonsendform.prop('disabled', false);
                            // createalert(data.status, data.message, 'companyupdate');
                            window.location.reload();
                        },
                        error: function(data) {
                            hideLoader();
                            $("#loadbeforeajax").css('display', 'none');
                            // buttonsendform.prop('disabled', false);
                            createalert(data.status, data.message, 'companyupdate');
                        }
                    });
                }
            }
        }
    </script>
    <script>
        function changetab_settings(id) {
            showLoader();
            $('.tab_bodyes .tab_body').removeClass('active');
            $('.tabs_sections .tabs_section').removeClass('active');
            $('.tab_body.active').removeClass('active');
            $('.tabs_section.active').removeClass('active');
            $('.tab_body .active').removeClass('active');
            $('.tabs_section .active').removeClass('active');
            $(`#${id}.tab_body`).addClass('active');
            $(`.${id}.tabs_section`).addClass('active');
            hideLoader();
        }
    </script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var preview = document.getElementById('preview');
                var image = new Image();
                image.src = reader.result;
                preview.innerHTML = '';
                preview.appendChild(image);
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <script defer>
tinymce.init({
            selector: '.company_description',
            media_live_embeds: true,
            file_picker_types: 'media',
            plugins: 'anchor autolink charmap textcolor codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'fontsize forecolor backcolor | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });

    </script>
@endpush
