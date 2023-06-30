<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}-{{ strtoupper(app()->getLocale()) }}">

<head>
    <meta name="generator" content="Globalmart Group">
    <meta name="author" content="Globalmart Group">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="fallback_locale" content="{{ config('app.fallback_locale') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name='robots' content='max-image-preview:large'>
    <link rel='dns-prefetch' href='http://fonts.googleapis.com/'>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:ital,wght@0,400;0,700;1,400;1,700&display=swap">
    {{-- For Og --}}
    <meta content="@yield('description', setting()->description[app()->getLocale() . '_description'])" name="description">
    <meta content="@yield('keywords', setting()->keywords[app()->getLocale() . '_keywords'] ?? null)" name="keywords">
    <meta property="og:site_name" content="{{ setting()->title[app()->getLocale() . '_title'] }}" />
    <meta property="og:title" content="@yield('title', setting()->title[app()->getLocale() . '_title'])" />
    <meta property="og:description" content="@yield('description', setting()->description[app()->getLocale() . '_description'])" />
    <meta property="og:keywords" content="@yield('keywords', setting()->keywords[app()->getLocale() . '_keywords'] ?? null)">
    <meta property="og:site_keywords" content="@yield('keywords', setting()->keywords[app()->getLocale() . '_keywords'] ?? null)">
    <meta property="og:type" content="products.buy" />
    <meta property="og:locale" content="{{ app()->getLocale() }}_{{ strtoupper(app()->getLocale()) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image:url" content="@yield('image', setting()->logo)" />
    <meta property="og:image:secure_url" content="@yield('image', setting()->logo)" />
    <meta property="og:image:alt" content="@yield('title', setting()->logo)" />
    <meta property="og:type" content="website" />
    <title>@yield('title', setting()->title[app()->getLocale() . '_title'])</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    {{-- For Og --}}

    {{-- Css --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/lineicons/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('css')
    {{-- Css --}}

    {{-- Yandex Metrica and Google Anayltics --}}
    @if (
        !empty(setting()) &&
            !empty(setting()->social_media) &&
            isset(setting()->social_media['yandex_metrica']) &&
            !empty(trim(setting()->social_media['yandex_metrica'])))
        <script type="text/javascript">
            (function(m, e, t, r, i, k, a) {
                m[i] = m[i] || function() {
                    (m[i].a = m[i].a || []).push(arguments)
                };
                m[i].l = 1 * new Date();
                for (var j = 0; j < document.scripts.length; j++) {
                    if (document.scripts[j].src === r) {
                        return;
                    }
                }
                k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(
                    k, a)
            })
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym({{ trim(setting()->social_media['yandex_metrica']) }}, "init", {
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true
            });
        </script>
        <noscript>
            <div><img src="https://mc.yandex.ru/watch/{{ trim(setting()->social_media['yandex_metrica']) }}"
                    style="position:absolute; left:-9999px;" alt="" /></div>
        </noscript>
    @endif
    @if (
        !empty(setting()) &&
            !empty(setting()->social_media) &&
            isset(setting()->social_media['GOOGLE_ANALYSTICS_MEASUREMENT_ID']) &&
            !empty(trim(setting()->social_media['GOOGLE_ANALYSTICS_MEASUREMENT_ID'])))
        <script async
            src="https://www.googletagmanager.com/gtag/js?id={{ trim(setting()->social_media['GOOGLE_ANALYSTICS_MEASUREMENT_ID']) }}">
        </script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', "{{ trim(setting()->social_media['GOOGLE_ANALYSTICS_MEASUREMENT_ID']) }}");
        </script>
    @endif
    {{-- Yandex Metrica and Google Anayltics --}}
</head>

<body>
    @if (
        !empty(setting()->social_media) &&
            isset(setting()->social_media['active_service']) &&
            !empty(setting()->social_media['active_service']) &&
            setting()->social_media['active_service'] == 'passive')
        <div class="row">
            <div class="container">
                <h1 class="text-center">BLOCKED BY <a href="https://globlalmart.az">GLOBALMART GROUP</a>.</h1>
            </div>
        </div>
    @else
        <div id="loader"> <i class="las la-spinner"></i></div>

        @include('layouts.partials.header')
        @yield('content')

        @include('layouts.partials.footer')
        {{-- Scripts --}}
        <script type="text/javascript" async defer src="{{ asset('assets/js/application.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/lazysizes.min.js') }}"></script>
        <script defer>
            setInterval(() => {
                var data = {
                    type: "user"
                };
                sendAjaxRequest('{{ route('api.notreadedmessages') }}', 'post', data, function(err, response) {
                    if (err) {
                        // console.log(err);
                    } else {
                        let parsedResponse = JSON.parse(response);
                        if (parsedResponse!=null) {
                            var profil_section_on_header = document.getElementById('profil_section_on_header');
                            var spanElement = document.createElement('span');
                            spanElement.className = "badge";
                            spanElement.style.position = "absolute";
                            spanElement.style.top = "0";
                            spanElement.style.right = "0";
                            spanElement.style.backgroundColor = "red";
                            spanElement.style.borderRadius = "50%";
                            spanElement.style.width = "25px";
                            spanElement.style.height = "25px";
                            spanElement.style.display = "inline-block";
                            spanElement.style.fontSize = "18px";
                            spanElement.style.textAlign = "center";
                            spanElement.style.color = "#fff";
                            spanElement.innerHTML = parsedResponse;

                            // Remove any existing <span> elements with the class 'badge'
                            var existingSpans = profil_section_on_header.getElementsByClassName('badge');
                            for (var i = 0; i < existingSpans.length; i++) {
                                existingSpans[i].remove();
                            }

                            // Append the new <span> element to the 'profil_section_on_header' element
                            profil_section_on_header.appendChild(spanElement);
                        }

                    }
                });
            }, 2000);
        </script>
        @stack('js')
        {{-- Scripts --}}
    @endif
</body>

</html>
