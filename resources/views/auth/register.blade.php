@extends('layouts.app')
@section('title')
    @if (!empty(standartpages('register', 'type')))
        {{ standartpages('register', 'type')->seo->name[app()->getLocale() . '_meta_title'] }}
    @else
        @if (!empty(lang_properties('welcome', 'keyword')))
            {{ lang_properties('welcome', 'keyword')->name }}
        @else
            @lang('additional.urls.welcome')
        @endif
    @endif
@endsection
@section('description')
    @if (!empty(standartpages('register', 'type')))
        {{ standartpages('register', 'type')->seo->description[app()->getLocale() . '_meta_description'] }}
    @else
        @if (!empty(lang_properties('welcome', 'keyword')))
            {{ lang_properties('welcome', 'keyword')->name }}
        @else
            @lang('additional.urls.welcome')
        @endif
    @endif
@endsection
@section('keywords')
    @if (!empty(standartpages('register', 'type')))
        {{ standartpages('register', 'type')->seo->keywords[app()->getLocale() . '_meta_keywords'] }}
    @else
        @if (!empty(lang_properties('welcome', 'keyword')))
            {{ lang_properties('welcome', 'keyword')->name }}
        @else
            @lang('additional.urls.welcome')
        @endif
    @endif
@endsection
@section('menu_register', 'active')
@push('css')
    <meta name='_token' content="{{ csrf_token() }}">
@endpush
@section('content')
    <section class="padding-y-100 padding-mobile-y-20">
        <div class="row">
            <div class="column column-45 bg_area bg_image mobile_column-0 border-rightradius bg_with_size"
                @if (!empty(background_images('register'))) style="background-image:url({{ App\Helpers\Helper::getImageUrl(background_images('register')->image, 'bgimages') }});min-height:500px;" @else style="background-image:url({{ asset('assets/images/register_bg.png') }});min-height:500px;" @endif>
            </div>
            <div class="column column-45 mobile_column-100">
                <h1 class="text-center section_title_with_green">@lang('additional.pages.register.title')</h1>
                <div class="row">
                    <div class="user_or_freelancer_row">
                        <div class="user_or_freelancer_tab user_or_freelancer_tab_user active" onclick="tabselect('user')">
                            @if (!empty(lang_properties('user', 'keyword')))
                                {{ lang_properties('user', 'keyword')->name }}
                            @else
                                @lang('additional.pages.register.user')
                            @endif
                        </div>
                        <div class="user_or_freelancer_tab user_or_freelancer_tab_freelancer"
                            onclick="tabselect('freelancer')">
                            @if (!empty(lang_properties('freelancer', 'keyword')))
                                {{ lang_properties('freelancer', 'keyword')->name }}
                            @else
                                @lang('additional.pages.register.freelancer')
                            @endif
                        </div>
                    </div>
                </div>
                <form class="margin-y-40" onsubmit="formsend()" id="formsend" style="width: 75%">
                    <div id="messages"></div>
                    @csrf
                    <input type="hidden" name="type" id="type_user" value="1">
                    <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                    <div class="form-group">
                        <input type="text" name="name_surname" placeholder="@lang('additional.forms.entername_surname')" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="@lang('additional.forms.enteremail')" class="form-control">
                    </div>
                    {{-- <div class="form-group">
                        <input type="text" name="phone" placeholder="@lang('additional.forms.enterphone')"
                            class="form-control">
                    </div> --}}
                    <div class="tab_freelancer margin-y-10">
                        <div class="row" style="justify-content: space-between">
                            <div class="column column-30 mobile_column-100">
                                <div class="form-group tab_company_section">
                                    <input type="file" id="company_logo" class="company_logo" name="company_logo"
                                        accept="image/*" onchange="previewImage(event)">
                                    <label for="company_logo" class="company_logo" id="preview">
                                        <i class="las la-camera-retro"></i>
                                        @lang('additional.forms.addimage')
                                    </label>
                                </div>
                            </div>
                            <div class="column column-65 mobile_column-100">

                                <div class="form-group tab_company_section">
                                    <textarea rows="8" name="company_description" class="form-control"
                                        placeholder="@if (!empty(lang_properties('companydescription', 'keyword'))) {{ lang_properties('companydescription', 'keyword')->name }} @else  @lang('additional.forms.company_description') @endif"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="@lang('additional.forms.enterpassword')" class="form-control">
                        <span class="eye-icon" id="password-eye-icon" onclick="password_toggle('password')"><i
                                class="las la-eye"></i></span>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" placeholder="@lang('additional.forms.enterpasswordconfirmation')"
                            class="form-control">
                        <span class="eye-icon" id="password_confirmation-eye-icon"
                            onclick="password_toggle('password_confirmation')"><i class="las la-eye"></i></span>
                    </div>
                    <div class="form-group"
                        style="justify-content:flex-start;align-items:flex-start;width:70%;margin:0 auto;">
                        <input type="checkbox" checked class="form-control" name="agreetermsofserviceprivarcypolicy"
                            id="agreetermsofserviceprivarcypolicy">
                        &nbsp; <label for="agreetermsofserviceprivarcypolicy">@lang('additional.forms.iagreetermsofserviceprivarypolicy')</label>
                    </div>
                    <div class="form-group">
                        <button class="login_button">@lang('additional.urls.register')</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
        function formsend() {
            showLoader();
            event.preventDefault();
            var formData = new FormData(document.querySelector('#formsend'));
            var nexprocess = {
                name_surname: false,
                email: false,
                password: false,
                password_confirmation: false,
                agreetermsofserviceprivarcypolicy: false,
                company_logo: false,
                company_description: false,
            };

            const data = {};
            for (const [key, value] of formData.entries()) {
                data[key] = value;
            }

            if (formData.get("name_surname") == null || formData.get("name_surname").length == 0) {
                hideLoader();
                createalert('error', '@lang('additional.messages.nullname_surname')');
                nexprocess['name_surname'] = false;
            } else {
                nexprocess['name_surname'] = true;
            }

            if (formData.get("email") == null || formData.get("email").length == 0) {
                hideLoader();
                createalert('error', '@lang('additional.messages.nullemail')');
                nexprocess['email'] = false;
            } else {
                if (!isValidEmail(formData.get("email"))) {
                    hideLoader();
                    createalert('error', '@lang('additional.messages.emailtypeerror')');
                    nexprocess['email'] = false;
                } else {
                    nexprocess['email'] = true;
                }
            }

            if (formData.get("password") == null || formData.get("password").length == 0) {
                hideLoader();
                createalert('error', '@lang('additional.messages.nullpassword')');
                nexprocess['password'] = false;
            } else {
                if (formData.get("password").length < 8) {
                    hideLoader();
                    createalert('error', '@lang('additional.messages.symbolsizeminimum', ['symbol' => 8])');
                    nexprocess['password'] = false;
                } else {
                    nexprocess['password'] = true;
                }
            }

            if (formData.get("password_confirmation") == null || formData.get("password_confirmation").length == 0) {
                hideLoader();
                createalert('error', '@lang('additional.messages.nullpassword_confirmation')');
                nexprocess['password_confirmation'] = false;
            } else {
                if (formData.get("password_confirmation").length < 8) {
                    hideLoader();
                    createalert('error', '@lang('additional.messages.symbolsizeminimum', ['symbol' => 8])');
                    nexprocess['password_confirmation'] = false;
                } else {
                    nexprocess['password_confirmation'] = true;
                }
            }

            if (formData.get('password') != null &&
                formData.get('password_confirmation') != null &&
                formData.get('password').length == formData.get('password_confirmation').length) {
                if (formData.get("password") == formData.get('password_confirmation')) {
                    nexprocess['password_confirmation'] = true;
                    nexprocess['password'] = true;
                } else {
                    hideLoader();
                    createalert('error', '@lang('additional.messages.passwordsdontmatch')');
                    nexprocess['password_confirmation'] = false;
                    nexprocess['password'] = false;
                }
            } else {
                hideLoader();
                createalert('error', '@lang('additional.messages.passwordsdontmatch')');
                nexprocess['password_confirmation'] = false;
                nexprocess['password'] = false;
            }

            if (formData.get("agreetermsofserviceprivarcypolicy") != null && formData.get(
                    "agreetermsofserviceprivarcypolicy") == "on") {
                nexprocess['agreetermsofserviceprivarcypolicy'] = true;
            } else {
                hideLoader();
                createalert('error', '@lang('additional.messages.youneedaccpetterms')')
                nexprocess['agreetermsofserviceprivarcypolicy'] = false;

            }

            var typeuser = document.getElementById('type_user').value;

            if(typeuser==3){
                if (formData.get("company_logo") == null || formData.get("company_logo").length == 0) {
                    hideLoader();
                    createalert('error', '@lang('additional.messages.nullcompany_logo')');
                    nexprocess['company_logo'] = false;
                } else {
                    nexprocess['company_logo'] = true;
                }

                if (formData.get("company_description") == null || formData.get("company_description").length == 0) {
                    hideLoader();
                    createalert('error', '@lang('additional.messages.nullcompany_description')');
                    nexprocess['company_description'] = false;
                } else {
                    nexprocess['company_description'] = true;
                }
            }

            if (nexprocess['password'] == true && nexprocess['email'] == true && nexprocess['name_surname'] == true &&
                nexprocess['password_confirmation'] == true && nexprocess['agreetermsofserviceprivarcypolicy'] == true) {
                if (typeuser == 1) {
                    sendAjaxRequest('{{ route('posts.register') }}', 'post', data, function(err, response) {
                        if (err) {
                            hideLoader();
                            createalert('error', err);
                        } else {
                            hideLoader();
                            let parsedResponse = JSON.parse(response);
                            createalert(parsedResponse.status, parsedResponse.message);
                            if (parsedResponse.url != null && parsedResponse.url.length > 0) {
                                window.location.href = parsedResponse.url;
                            }
                        }
                    });
                } else {
                    if (nexprocess['company_logo'] == true && nexprocess['company_description'] == true) {
                        $.ajax({
                            url: "{{ route('posts.register') }}",
                            data: formData,
                            processData: false,
                            contentType: false,
                            type: 'post',
                            success: function(data) {
                                hideLoader();
                                createalert(data.status, data.message);
                                if (data.url != null && data.url.length > 0) {
                                    window.location.href = data.url;
                                }
                            },
                            error: function(data) {
                                hideLoader();
                                createalert(data.status, data.message, 'profileupdate');
                            }
                        });
                    }
                }
            }

        }
    </script>
    <script defer>
        function tabselect(id) {
            var tabs = document.getElementsByClassName('user_or_freelancer_tab');
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove('active');
            }
            var selectedTab = document.getElementsByClassName(`user_or_freelancer_tab_${id}`);
            if (selectedTab.length > 0) {
                selectedTab[0].classList.add('active');
            }
            var tabfreelancer = document.getElementsByClassName('tab_freelancer');
            if (id == "freelancer") {
                tabfreelancer[0].style.display = "block";
                document.getElementById('type_user').value = 3;
            } else {
                tabfreelancer[0].style.display = "none";
                document.getElementById('type_user').value = 1;
            }
        }
    </script>
    <script defer>
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
@endpush
