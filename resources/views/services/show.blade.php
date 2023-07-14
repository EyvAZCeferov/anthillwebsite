@extends('layouts.app')
@section('title')
    @if (!empty($data->seo) && !empty($data->seo->name))
        {{ $data->seo->name[app()->getLocale() . '_meta_title'] ?? $data->name[app()->getLocale() . '_name'] }}
    @else
        {{ $data->name[app()->getLocale() . '_name'] }} -- #{{ $data->code }}
    @endif
@endsection

@section('description')
    @if (!empty($data->seo) && !empty($data->seo->name))
        {{ $data->seo->description[app()->getLocale() . '_meta_description'] ?? $data->description[app()->getLocale() . '_description'] }}
    @else
        {{ App\Helpers\Helper::strip_tags_with_whitespace($data->decsription[app()->getLocale() . '_description'] ?? null) }}
    @endif
@endsection
@section('keywords')
    @if (!empty($data->seo) && !empty($data->seo->name))
        {{ $data->seo->keywords[app()->getLocale() . '_meta_keywords'] ?? $data->name[app()->getLocale() . '_name'] }}
    @else
        {{ $data->name[app()->getLocale() . '_name'] }} -- #{{ $data->code }}
    @endif
@endsection
@if (!empty($data) && isset($data->images) && !empty($data->images) && isset($data->images[0]))
    @section('image', App\Helpers\Helper::getImageUrl($data->images[0]->original_images, 'products') ?? null)
@endif
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .fancybox-button--close {
            display: block !important;
            visibility: visible !important;
        }

    </style>
@endpush
@push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
        integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                animationEffect: false,
                // arrows          : true,
                clickContent: false,
                toolbar: {
                    items: {
                        close: {
                            tpl: '<button data-fancybox-close class="fancybox-button fancybox-button--close" title="Close"></button>'
                        }
                    }
                },
            });
        });
    </script>
    <script>
        function chatwithuser(user_id, company_id, product_id) {
            showLoader();
            if ((user_id != null && user_id.length > 0 && user_id != '' && user_id != ' ') && (company_id != null &&
                    company_id.length > 0 && company_id != '' && company_id != ' ')) {
                let data = {
                    user_id: company_id,
                    auth_id: user_id,
                    product_id: product_id
                };

                sendAjaxRequest('{{ route('api.createandredirectchat') }}', 'post', data, function(err, response) {
                    if (err) {
                        hideLoader();
                    } else {

                        hideLoader();
                        if (response != null) {
                            let parsedResponse = JSON.parse(response);

                            createalert(parsedResponse.status, parsedResponse.message,'errormsj');
                            if (parsedResponse.url != null && parsedResponse.url.length > 0) {
                                window.location.href = parsedResponse.url;
                            }
                        }

                    }
                });

            } else {
                var elem =
                    `<div id="modal-wrapper">
                        <div class="modal_section">
                            <div class="w-100 right">
                                <span class="cancel_icon" onclick="cancelmodal()">
                                    <i class="las la-times"></i>
                                </span>
                            </div>
                            <div class="modal_content">
                                <div class="w-100 center">
                                    <h2 class="service_title">@lang('additional.pages.auth.profileinfo')</h2>
                                </div>
                                <form class="margin-y-10" onsubmit='registerandchatithuser("registerandchatithuser")' id="registerandchatithuser">
                                    <div id="messages"></div>
                                    @csrf
                                    <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                                    <input type='hidden' name='user_id' value='${company_id}' />
                                    <input type='hidden' name='product_id' value='{{ $data->id }}' />
                                    <div class="form-group">
                                        <input type="text" name="name_surname" placeholder="@lang('additional.forms.entername_surname')" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="@lang('additional.forms.enteremail')" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button class="login_button">@lang('additional.buttons.forwardtochat')</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>`;
                $("section#serviceshow").append(elem);
                hideLoader();

            }
        }
    </script>

    {{-- registerandchatithuser --}}
    <script>
        function registerandchatithuser(id) {
            event.preventDefault();
            showLoader();
            var form = $(`form#${id}`);

            var data = form.serialize();
            $.ajax({
                url: `{{ route('api.registerandchatithuser') }}`,
                type: "POST",
                dataType: 'json',
                data,
                success: function(data) {
                    hideLoader();
                    createalert(data.status, data.message, id);
                    if (data.url != null && data.url.length > 0) {
                        window.location.href = data.url;
                    }
                },
                error: function(data) {
                    hideLoader();
                    createalert(data.status, data.message, id);
                }
            });
        }
    </script>
    {{-- registerandchatithuser --}}

    <script>
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            asNavFor: '.slider-nav',
            prevArrow: '<button type="button" class="slick-button slick-prev"><i class="las la-angle-double-left"></i></button>',
            nextArrow: '<button type="button" class="slick-button slick-next"><i class="las la-angle-double-right"></i></button>',
            speed: 1000,
            lazyLoad: 'anticipated',
            autoplay: true,
            autoplaySpeed: 2000,
        });
        $('.slider-nav').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: false,
            centerMode: false,
            focusOnSelect: true,
            speed: 1000,
            lazyLoad: 'anticipated',

            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768, // Mobil
                    settings: {
                        slidesToShow: 1, // Mobilde 3 öğe gösterilecek
                        slidesToScroll: 1
                    }
                }
            ]
        });
    </script>

    <script>
        const yildizlar = document.querySelectorAll(".yildizlar input");
        let rating = 0;

        for (let i = 0; i < yildizlar.length; i++) {
            yildizlar[i].addEventListener("change", function() {
                rating = parseInt(this.value);
            });
        }
    </script>

    <script>
        function formsend() {
            showLoader();
            event.preventDefault();
            var formData = new FormData(document.querySelector('#formsend'));
            var nexprocess = {
                message: false,
            };

            const data = {};
            for (const [key, value] of formData.entries()) {
                data[key] = value;
            }

            if (formData.get("message") == null || formData.get("message").length == 0) {
                createalert('error', '@lang('additional.messages.nullmessage')');
                nexprocess['message'] = false;
                hideLoader();
            } else {
                nexprocess['message'] = true;
            }

            if (nexprocess['message'] == true) {
                sendAjaxRequest('{{ route('comments.share') }}', 'post', data, function(err, response) {
                    if (err) {
                        hideLoader();
                        createalert('error', err);
                    } else {
                        hideLoader();
                        let parsedResponse = JSON.parse(response);
                        createalert(parsedResponse.status, parsedResponse.message);
                        window.location.href = '{{ request()->url() }}';
                    }
                });
            }

        }
    </script>
    <script>
        function scrolltocommentarea() {
            $('html, body').animate({
                scrollTop: $('#commentarea').offset().top
            }, 1000);
        }
    </script>
    <script defer>
        $(function(){
            var elements = $('[style*="text-indent"]');

// Her bir elemanın "text-indent" özelliğini değiştirir
elements.each(function() {
  var currentStyle = $(this).attr('style');
  var newStyle = currentStyle.replace(/text-indent:\s*-?\d+\.?\d*pt;/, 'text-indent: 20pt;');
  $(this).attr('style', newStyle);
});
        })
    </script>
@endpush

@section('content')
    <section class="margin-y-20" id="serviceshow">
        <div class="container" id="service-{{ $data->code }}">
            <br>
            <div class="row">
                <h1 class="w-100 serviceshowname">{{ $data->name[app()->getLocale() . '_name'] }}</h1>
            </div>
            @include('companies.company_topper_data', ['data' => $data->user, 'product' => $data])
            <div class="w-100">
                <div class="row service_new_design">
                    <div class="column-70 mobile_column-100">
                        <div class="slider-for">
                            @foreach ($data->images as $image)
                                @if (!empty($image) && isset($image->original_images) && !empty(trim($image->original_images)))
                                    <a class="slide thumbnail" data-fancybox="group"
                                        href="{{ App\Helpers\Helper::getImageUrl($image->original_images, 'products') ?? null }}">
                                        <span class="magnifier"><i class="las la-search-plus"></i></span>
                                        <img draggable="false"
                                            src="{{ App\Helpers\Helper::getImageUrl($image->original_images, 'products') ?? null }}"
                                            alt="{{ $data->name[app()->getLocale() . '_name'] }}">
                                    </a>
                                @endif
                            @endforeach
                        </div>
                        @if (count($data->images) > 1)
                            <div class="slider-nav">
                                @foreach ($data->images as $image)
                                    @if (!empty($image) && isset($image->original_images) && !empty(trim($image->original_images)))
                                        <div class="slide thumbnail">
                                            <img draggable="false"
                                                src="{{ App\Helpers\Helper::getImageUrl($image->original_images, 'products') ?? null }}"
                                                alt="{{ $data->name[app()->getLocale() . '_name'] }}">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="column-25 mobile_column-100 right_section">
                        <h3 class="price"><span style="font-size:12px;color:gray;font-weight:bold">@if(!empty(lang_properties('startsat','keyword'))) {{ lang_properties('startsat','keyword')->name }} @else  Starts at @endif</span>
                            {{ $data->price }}€</h3>
                        <hr class="seperator" />
                        <div class="servicetable">
                            <table>
                                <tbody>
                                    @php($previousGroupId = null)

                                    @foreach ($data->attributes as $attribute_el)
                                        @php($group = $attribute_el->attributegroup)
                                        @php($attribute = $attribute_el->attribute)

                                        @if (!empty($attribute) && isset($attribute->name['az_name']) && trim($attribute->name['az_name']) != null)
                                            @if ($previousGroupId !== $attribute_el->attribute_group_id)
                                                <tr id="{{ $attribute_el->id }}">
                                                    <td class="key">{{ $group->name[app()->getLocale() . '_name'] }}
                                                    </td>
                                                    <td class="value">{{ $attribute->name[app()->getLocale() . '_name'] }}
                                                        @if ($group->datatype == 'price')
                                                            €
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif

                                            @php($previousGroupId = $attribute_el->attribute_group_id)
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row text-center">
                            <button class="sendchat"
                                onclick="chatwithuser('{{ auth()->check() && !empty(auth()->user()) ? auth()->user()->id : null }}','{{ $data->user_id }}','{{ $data->id }}')"><i
                                    class="las la-comments"></i>@if(!empty(lang_properties('book_now','keyword'))) {{ lang_properties('book_now','keyword')->name }} @else  @lang("additional.buttons.sendchat") @endif</button>
                                    <form action="return;" id="errormsj" style="width:100%;"><div id="messages"></div></form>
                        </div>
                    </div>
                </div>
                <br>
                @include('services.rating_section', ['data' => $data, 'comments' => $data->comments])
                <br>
                <h3 class="tab_section_title">@lang('additional.pages.services.serviceinfo')</h3>
                <div class="desc_area">{!! $data->description[app()->getLocale() . '_description'] !!}</div>
                <br />
                <br />
                @include('companies.company_section', ['data' => $data->user])
                <br />
                @include('services.comments', ['comments' => $data->comments])

            </div>
        </div>
    </section>
    <br>

@endsection
