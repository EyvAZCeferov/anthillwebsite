@extends('layouts.app')
@section('title')
    @if (!empty(standartpages('login', 'type')))
        {{ standartpages('login', 'type')->seo->name[app()->getLocale() . '_meta_title'] }}
    @else
        @if(!empty(lang_properties('welcome','keyword'))) {{ lang_properties('welcome','keyword')->name }} @else  @lang("additional.urls.welcome") @endif
    @endif
@endsection
@section('description')
    @if (!empty(standartpages('login', 'type')))
        {{ standartpages('login', 'type')->seo->description[app()->getLocale() . '_meta_description'] }}
    @else
        @if(!empty(lang_properties('welcome','keyword'))) {{ lang_properties('welcome','keyword')->name }} @else  @lang("additional.urls.welcome") @endif
    @endif
@endsection
@section('keywords')
    @if (!empty(standartpages('login', 'type')))
        {{ standartpages('login', 'type')->seo->keywords[app()->getLocale() . '_meta_keywords'] }}
    @else
        @if(!empty(lang_properties('welcome','keyword'))) {{ lang_properties('welcome','keyword')->name }} @else  @lang("additional.urls.welcome") @endif
    @endif
@endsection
@section('menu_login', 'active')
@push('css')
    <meta name='_token' content="{{ csrf_token() }}">
@endpush
@section('content')

    <section class="padding-y-100 padding-mobile-y-20">
        <div class="row">
            <div class="column column-45 bg_area bg_image mobile_column-0 border-rightradius bg_with_size"
                @if (!empty(background_images('login'))) style="background-image:url({{ App\Helpers\Helper::getImageUrl(background_images('login')->image, 'bgimages') }})" @else style="background-image:url({{ asset('assets/images/login_bg.png') }})" @endif>
            </div>
            <div class="column column-45 mobile_column-100">
                <h1 class="text-center section_title_with_green">@lang('additional.urls.login')</h1>

                <form class="margin-y-40" onsubmit="formsend()" id="formsend" style="width: 75%">
                    <div id="messages"></div>
                    @csrf
                    <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                    <div class="form-group">
                        <input type="email" name="email" placeholder="@lang('additional.forms.enteremail')" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="@lang('additional.forms.enterpassword')" class="form-control">
                        <span class="eye-icon" id="password-eye-icon" onclick="password_toggle('password')"><i
                                class="las la-eye"></i></span>
                    </div>
                    <a href="{{ route('auth.forgetpassword') }}" class="forget_password">@lang('additional.urls.forgetpassword')</a>
                    <div class="form-group"
                        style="justify-content:flex-start;align-items:flex-start;width:70%;margin:0 auto;">
                        <input type="checkbox" checked class="form-control" name="rememberme" id="rememberme">
                        &nbsp; <label for="rememberme">@lang('additional.forms.rememberme')</label>
                    </div>
                    <div class="form-group">
                        <button class="login_button">@lang('additional.urls.login')</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        function formsend() {
            showLoader();
            event.preventDefault();
            var formData = new FormData(document.querySelector('#formsend'));
            var nexprocess = {
                email: false,
                password: false,
            };

            const data = {};
            for (const [key, value] of formData.entries()) {
                data[key] = value;
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

            if (nexprocess['password'] == true && nexprocess['email'] == true) {
                sendAjaxRequest('{{ route('posts.login') }}', 'post', data, function(err, response) {
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
            }

        }
    </script>
@endpush
