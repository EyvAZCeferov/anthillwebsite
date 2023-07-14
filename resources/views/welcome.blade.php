@extends('layouts.app')
@section('menu_welcome', 'active')
@section('title')
    @if (!empty(standartpages('homepage', 'type')))
        {{ standartpages('homepage', 'type')->seo->name[app()->getLocale() . '_meta_title'] }}
    @else
        @if(!empty(lang_properties('welcome','keyword'))) {{ lang_properties('welcome','keyword')->name }} @else  @lang("additional.urls.welcome") @endif
    @endif
@endsection
@section('description')
    @if (!empty(standartpages('homepage', 'type')))
        {{ standartpages('homepage', 'type')->seo->description[app()->getLocale() . '_meta_description'] }}
    @else
        @if(!empty(lang_properties('welcome','keyword'))) {{ lang_properties('welcome','keyword')->name }} @else  @lang("additional.urls.welcome") @endif
    @endif
@endsection
@section('keywords')
    @if (!empty(standartpages('homepage', 'type')))
        {{ standartpages('homepage', 'type')->seo->keywords[app()->getLocale() . '_meta_keywords'] }}
    @else
        @if(!empty(lang_properties('welcome','keyword'))) {{ lang_properties('welcome','keyword')->name }} @else  @lang("additional.urls.welcome") @endif
    @endif
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
        integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.bg_sliders').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: '<button type="button" class="slick-button slick-prev"><i class="las la-angle-double-left"></i></button>',
            nextArrow: '<button type="button" class="slick-button slick-next"><i class="las la-angle-double-right"></i></button>',
            speed: 1000,
            height: 500,
            lazyLoad: 'anticipated',
            autoplay: true,
            autoplaySpeed: 2000,
            arrows:true
        });
        $(".categories_items_slider").slick({
            infinite: true,
            slidesToShow: 10,
            slidesToScroll: 4,
            speed: 1000,
            height: 500,
            lazyLoad: 'anticipated',
            autoplay: true,
            arrows:false,
            autoplaySpeed: 2000,
            responsive: [{
                    breakpoint: 1024, // Tablet
                    settings: {
                        slidesToShow: 6, // Tablette 5 öğe gösterilecek
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 768, // Mobil
                    settings: {
                        slidesToShow: 4, // Mobilde 3 öğe gösterilecek
                        slidesToScroll: 3
                    }
                }
            ]
        });
        $(".customers_items_sliders").slick({
            infinite: true,
            slidesToShow: 8,
            slidesToScroll: 4,
            speed: 1000,
            height: 500,
            lazyLoad: 'anticipated',
            autoplay: true,
            autoplaySpeed: 2000,
            arrows:false,
            responsive: [{
                    breakpoint: 1024, // Tablet
                    settings: {
                        slidesToShow: 5, // Tablette 5 öğe gösterilecek
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 768, // Mobil
                    settings: {
                        slidesToShow: 4, // Mobilde 3 öğe gösterilecek
                        slidesToScroll: 3
                    }
                }
            ]
        });
    </script>
    <script>
        function formsend(id) {
            showLoader();
            event.preventDefault();
            var formData = new FormData(document.querySelector(`#${id}`));
            var nexprocess = {
                email: false,
                phone: false,
                name: false,
                message: false,
            };

            const data = {};
            for (const [key, value] of formData.entries()) {
                data[key] = value;
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

            if (formData.get("name") == null || formData.get("name").length == 0) {
                hideLoader();
                createalert('error', '@lang('additional.messages.nullname_surname')', id);
                nexprocess['name'] = false;
            } else {
                nexprocess['name'] = true;
            }


            if (formData.get("message") == null || formData.get("message").length == 0) {
                hideLoader();
                createalert('error', '@lang('additional.messages.nullmessage')', id);
                nexprocess['message'] = false;
            } else {
                nexprocess['message'] = true;
            }

            if (nexprocess['name'] == true && nexprocess['email'] == true && nexprocess['message'] == true) {
                sendAjaxRequest('{{ route('contactus.sendform') }}', 'post', data, function(err, response) {
                    if (err) {
                        hideLoader();
                        createalert('error', err, id);
                    } else {
                        hideLoader();
                        let parsedResponse = JSON.parse(response);
                        createalert(parsedResponse.status, parsedResponse.message, id);
                        if (parsedResponse.url != null && parsedResponse.url.length > 0) {
                            window.location.href = parsedResponse.url;
                        }
                    }
                });
            }

        }
    </script>
@endpush
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .searchkeywords {
            width: 100% !important;
        }
    </style>
@endpush
@section('description')
    {{ setting()->description[app()->getLocale() . '_description'] }}

@endsection
@section('content')
    <div class="container">
        @if (count(sliders()) > 0)
            <section>
                <div class="bg_sliders">
                    @foreach (sliders() as $slider)
                        <div class="bg_slider lazyload"
                            style="background-image:url('{{ App\Helpers\Helper::getImageUrl($slider->image, 'sliders') }}')">
                            @if (!empty($slider->description) && !empty(trim($slider->description[app()->getLocale() . '_description'])))
                                <div class="slider_description">
                                    {!! trim($slider->description[app()->getLocale() . '_description']) !!}
                                </div>
                            @endif
                            @if (isset($slider->url) && !empty($slider->url))
                                <button class="slider_button"
                                    onclick="window.open(`{{ $slider->url }}`)">@lang('additional.buttons.more')</button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
        <section>
            <div class="row">
                <h2 class="text-center w-100">@if(!empty(lang_properties('categories','keyword'))) {{ lang_properties('categories','keyword')->name }} @else  @lang('additional.urls.categories') @endif</h2>
            </div>
            <div class="categories_items_slider" style="margin-top:10px">
                @foreach (categories() as $category)
                    <div class="category_item"
                        onclick="window.location.href=`/services?category={{ $category->slugs[app()->getLocale() . '_slug'] }}`">
                        <div class="icon"
                            @if (isset($category->color) && !empty($category->color)) style="background-color:{{ $category->color }}" @endif>
                            {!! $category->icon !!}</div>
                        <p class="name">{{ $category->name[app()->getLocale() . '_name'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section>
            @include('services.search_filter', ['type' => 'services'])
        </section>

        <section>
            <div class="row services" id="datas">
                @if (count(products()->take(24)) > 0)
                    @foreach (products()->take(24) as $product)
                        @include('services.service_element', ['data' => $product])
                    @endforeach
                @else
                    <p class="text-center w-100 text-danger">@lang('additional.pages.category.datanotfound')</p>
                @endif
            </div>
        </section>

        <section>
            <div class="row text-center">
                <a class="more_button_section" href="{{ route('services.index') }}">@lang('additional.buttons.more')</a>
            </div>
        </section>

        @if (!empty(user_companies()))
            <section class="bg_gray">
                <div class="row ">
                    <h2 class="text-center w-100">@if(!empty(lang_properties('freelancers','keyword'))) {{ lang_properties('freelancers','keyword')->name }} @else  @lang("additional.urls.customers") @endif</h2>
                </div>
                <div class="customers_items_sliders padding-y-15">
                    @foreach (user_companies() as $company)
                        @if(!empty($company) && !empty($company->additionalinfo) && !empty($company->additionalinfo->company_slugs))
                            <div class="customers_items_slider"
                                onclick="window.location.href=`/company/{{ $company->additionalinfo->company_slugs[app()->getLocale() . '_slug'] }}`">
                                <div class="image">
                                    <img data-src="{{ App\Helpers\Helper::getImageUrl($company->additionalinfo->company_image, 'users') }}"
                                    class="lazyload blur-up"
                                        alt="{{ $company->additionalinfo->company_name[app()->getLocale() . '_name'] }}">
                                </div>
                                <h5 class="name">{{ $company->additionalinfo->company_name[app()->getLocale() . '_name'] }}
                                </h5>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="row text-center">
                    <a class="more_button_section" href="{{ route('companies.index') }}">@lang('additional.buttons.more')</a>
                </div>
                <div class="padding-y-10"></div>
            </section>
        @endif
    </div>
    <section style="margin:0;">
        <form class="w-100 row bg_white" onsubmit="formsend('formsend_contactus')" id="formsend_contactus">
            @csrf
            <input type="hidden" name="language" value="{{ app()->getLocale() }}">
            <div class="row">
                <div id="messages"></div>
            </div>
            <div class="contactusform w-100">
                <div class="form_element center">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="@lang('additional.forms.entername_surname')" />
                    </div>
                </div>
                <div class="form_element justify-space-between">
                    <div class="column column-45">
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" placeholder="@lang('additional.forms.enteremail')" />
                        </div>
                    </div>
                    <div class="column column-45">
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" onkeyup="phonewriting('phone')"
                                placeholder="@lang('additional.forms.enterphone')" />
                        </div>
                    </div>
                </div>
                <div class="form_element center">
                    <div class="form-group">
                        <textarea class="form-control" name="message" placeholder="@lang('additional.forms.message')" rows='15'></textarea>
                    </div>
                </div>
                <div class="form_element center">
                    <button type="submit" class="submit_button">@lang('additional.buttons.submit')</button>
                </div>

            </div>
        </form>
    </section>

@endsection
