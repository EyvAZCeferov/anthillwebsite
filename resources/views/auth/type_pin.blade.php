@extends('layouts.app')
@section('title')
    @lang('additional.urls.enterpincode')
@endsection
@push('css')
    <meta name='_token' content="{{ csrf_token() }}">
@endpush
@section('content')
    <section class="padding-y-100 padding-mobile-y-20">
        <div class="row">
            <div class="column column-45 bg_area bg_image mobile_column-0 border-rightradius bg_with_size"
                style="background-image:url({{ asset('assets/images/forgetpassword_bg.png') }})">
            </div>
            <div class="column column-45 mobile_column-100">
                <h1 class="text-center section_title_with_green">@lang('additional.urls.enterpincode')</h1>

                <form class="margin-y-40" onsubmit="formsend()" id="formsend">
                    <div id="messages"></div>
                    @csrf
                    <input type="hidden" name="email" value="{{ request()->input('email') }}">
                    <input type="hidden" name="token" value="{{ request()->input('token') }}">
                    <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                    <div class="row form-elements">
                        <div class="form-element">
                            <input type="number" onkeyup="moveOnMax(this, 'number2')" onkeydown="backsp(this, 'number1')"
                                name="number1" class="form-input" pattern="\d" maxlength="1">
                        </div>
                        <div class="form-element">
                            <input type="number" onkeyup="moveOnMax(this, 'number3')" onkeydown="backsp(this, 'number2')"
                                name="number2" class="form-input" pattern="\d" maxlength="1">
                        </div>
                        <div class="form-element">
                            <input type="number" onkeyup="moveOnMax(this, 'number4')" onkeydown="backsp(this, 'number3')"
                                name="number3" name="number3" class="form-input" pattern="\d" maxlength="1">
                        </div>
                        <div class="form-element">
                            <input type="number" onkeyup="moveOnMax(this, 'submit')" onkeydown="backsp(this, 'submit')"
                                name="number4" class="form-input" pattern="\d" maxlength="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="login_button">@lang('additional.buttons.submit')</button>
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
                number: false,
            };

            const data = {};
            for (const [key, value] of formData.entries()) {
                data[key] = value;
            }

            if ((formData.get("number1") == null || formData.get("number1").length == 0) && (formData.get("number2") ==
                    null || formData.get("number2").length == 0) && (formData.get("number3") ==
                    null || formData.get("number3").length == 0) && (formData.get("number4") ==
                    null || formData.get("number4").length == 0)) {
                        hideLoader();
                createalert('error', '@lang('additional.messages.nullnumber')');
                nexprocess['number'] = false;
            } else {
                nexprocess['number'] = true;
            }

            if (nexprocess['number'] == true) {
                sendAjaxRequest('{{ route('posts.submitpin') }}', 'post', data, function(err, response) {
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

        window.onload = function() {
            document.getElementsByName('number1')[0].focus();
        }

        function moveOnMax(field, nextFieldID) {

            if (field.value.length >= 1) {
                if (nextFieldID != "submit") {
                    document.getElementsByName(nextFieldID)[0].focus();
                }
            }

        }

        function backsp(field, prevFieldID) {

            if (field.value.length == 0) {
                if (prevFieldID != "submit") {
                    document.getElementsByName(prevFieldID)[0].focus();
                }

            }
        }
    </script>
@endpush
