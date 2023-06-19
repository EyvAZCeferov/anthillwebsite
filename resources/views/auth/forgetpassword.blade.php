@extends('layouts.app')
@section('title')
    @lang('additional.urls.forgetpassword')
@endsection
@section('menu_login', 'active')
@push('css')
    <meta name='_token' content="{{ csrf_token() }}">
@endpush
@section('content')
    <section class="padding-y-100 padding-mobile-y-20">
        <div class="row">
            <div class="column column-45 bg_area bg_image mobile_column-0 border-rightradius bg_with_size"
                @if(!empty(background_images('forget_password'))) style="background-image:url({{ App\Helpers\Helper::getImageUrl(background_images('forget_password')->image, 'bgimages') }})" @else style="background-image:url({{ asset('assets/images/forgetpassword_bg.png') }})" @endif
                >
            </div>
            <div class="column column-45 mobile_column-100">
                <h1 class="text-center section_title_with_green">@lang('additional.urls.forgetpassword')</h1>

                <form class="margin-y-40" onsubmit="formsend()" id="formsend" style="width:75%">
                    <div id="messages"></div>
                    @csrf
                    <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                    <div class="form-group">
                        <input type="email" name="email" placeholder="@lang('additional.forms.enteremail')" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="login_button">@lang('additional.urls.updatepassword')</button>
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
            };

            const data = {};
            for (const [key, value] of formData.entries()) {
                data[key] = value;
            }

            if (formData.get("email") == null || formData.get("email").length == 0) {
                createalert('error', '@lang('additional.messages.nullemail')');
                nexprocess['email'] = false;
                hideLoader();
            } else {
                if (!isValidEmail(formData.get("email"))) {
                    createalert('error', '@lang('additional.messages.emailtypeerror')');
                    nexprocess['email'] = false;
                    hideLoader();
                } else {
                    nexprocess['email'] = true;
                }
            }

            if (nexprocess['email'] == true) {
                sendAjaxRequest('{{ route('posts.forgetpassword') }}', 'post', data, function(err, response) {
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
