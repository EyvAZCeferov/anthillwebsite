@extends('layouts.app')
@section('title')
    @if(!empty(standartpages('register','type')))
        {{standartpages('register','type')->seo->name[app()->getLocale().'_meta_title']}}
    @else
        @if(!empty(lang_properties('welcome','keyword'))) {{ lang_properties('welcome','keyword')->name }} @else  @lang("additional.urls.welcome") @endif
    @endif
@endsection
@section('description')
    @if(!empty(standartpages('register','type')))
        {{standartpages('register','type')->seo->description[app()->getLocale().'_meta_description']}}
    @else
        @if(!empty(lang_properties('welcome','keyword'))) {{ lang_properties('welcome','keyword')->name }} @else  @lang("additional.urls.welcome") @endif
    @endif
@endsection
@section('keywords')
    @if(!empty(standartpages('register','type')))
        {{standartpages('register','type')->seo->keywords[app()->getLocale().'_meta_keywords']}}
    @else
        @if(!empty(lang_properties('welcome','keyword'))) {{ lang_properties('welcome','keyword')->name }} @else  @lang("additional.urls.welcome") @endif
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
                @if(!empty(background_images('register'))) style="background-image:url({{ App\Helpers\Helper::getImageUrl(background_images('register')->image, 'bgimages') }});min-height:500px;" @else style="background-image:url({{ asset('assets/images/register_bg.png') }});min-height:500px;" @endif
                >
            </div>
            <div class="column column-45 mobile_column-100">
                <h1 class="text-center section_title_with_green">@lang('additional.pages.register.title')</h1>

                <form class="margin-y-40" onsubmit="formsend()" id="formsend" style="width: 75%">
                    <div id="messages"></div>
                    @csrf
                    <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                    <div class="form-group">
                        <input type="text" name="name_surname" placeholder="@lang('additional.forms.entername_surname')" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="@lang('additional.forms.enteremail')" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" placeholder="@lang('additional.forms.enterphone')"
                            class="form-control">
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
    <script>
        function formsend() {
            showLoader();
            event.preventDefault();
            var formData = new FormData(document.querySelector('#formsend'));
            var nexprocess = {
                name_surname: false,
                email: false,
                phone: false,
                password: false,
                password_confirmation: false,
                agreetermsofserviceprivarcypolicy:false,
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

            if (formData.get("phone") == null || formData.get("phone").length == 0) {
                hideLoader();
                createalert('error', '@lang('additional.messages.nullphone')');
                nexprocess['phone'] = false;
            } else {
                var phonenumb = validPhone(formData.get('phone'));
                document.querySelector('input[name="phone"]').value = phonenumb;
                nexprocess['phone'] = true;
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

            if(formData.get("agreetermsofserviceprivarcypolicy") !=null && formData.get("agreetermsofserviceprivarcypolicy")=="on"){
                nexprocess['agreetermsofserviceprivarcypolicy']=true;
            }else{
                hideLoader();
                createalert('error','@lang('additional.messages.youneedaccpetterms')')
                nexprocess['agreetermsofserviceprivarcypolicy']=false;

            }

            if (nexprocess['password'] == true && nexprocess['email'] == true && nexprocess['name_surname'] == true &&
                nexprocess['phone'] == true && nexprocess['password_confirmation'] == true && nexprocess['agreetermsofserviceprivarcypolicy']==true) {
                sendAjaxRequest('{{ route('posts.register') }}', 'post', data, function(err, response) {
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
