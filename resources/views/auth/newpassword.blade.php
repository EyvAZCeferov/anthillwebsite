@extends('layouts.app')
@section('title')
    @lang('additional.urls.newpassword')
@endsection
@section('menu_login', 'active')
@push('css')
    <meta name='_token' content="{{ csrf_token() }}">
@endpush
@section('content')
    <section class="padding-y-100 padding-mobile-y-20">
        <div class="row">
            <div class="column column-45 bg_area bg_image mobile_column-0 border-rightradius bg_with_size"
                style="background-image:url({{ asset('assets/images/login_bg.png') }})">
            </div>
            <div class="column column-45 mobile_column-100">
                <h1 class="text-center section_title_with_green">@lang('additional.urls.newpassword')</h1>

                <form class="margin-y-40" onsubmit="formsend()" id="formsend">
                    <div id="messages"></div>
                    @csrf
                    <input type="hidden" name="language" value="{{ app()->getLocale() }}" />

                    <div class="form-group">
                        <input type="password" name="password" placeholder="@lang('additional.forms.enternewpassword')" class="form-control">
                        <span class="eye-icon" id="password-eye-icon" onclick="password_toggle('password')"><i
                                class="las la-eye"></i></span>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password_confirmation" placeholder="@lang('additional.forms.enterpasswordconfirmation')" class="form-control">
                        <span class="eye-icon" id="password_confirmation-eye-icon" onclick="password_toggle('password_confirmation')"><i
                                class="las la-eye"></i></span>
                    </div>

                    <div class="form-group">
                        <button class="login_button">@lang('additional.urls.newpassword')</button>
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
                password: false,
                password_confirmation: false,
            };

            const data = {};
            for (const [key, value] of formData.entries()) {
                data[key] = value;
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

            if (nexprocess['password'] == true && nexprocess['email'] == true) {
                sendAjaxRequest('{{ route('posts.login') }}', 'post', data, function(err, response) {
                    if (err) {
                        hideLoader();
                        createalert('error', err);
                    } else {
                        hideLoader();
                        let parsedResponse = JSON.parse(response);
                        createalert(parsedResponse.status, parsedResponse.message);
                        if(parsedResponse.url!=null && parsedResponse.url.length>0){
                            window.location.href=parsedResponse.url;
                        }
                    }
                });
            }

        }
    </script>
@endpush
