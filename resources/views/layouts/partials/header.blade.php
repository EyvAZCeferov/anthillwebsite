<header class="main_header padding-y-5">
    <div class="container">
        <div class="row padding-x-5">
            <div
                class="column column-15 mobile_column-50 mini_mobile_column-20 image">
                <img
                src="{{ App\Helpers\Helper::getImageUrl(setting()->logo, 'settings') }}"
                class="brend-image"
                    onclick="window.location.href=`{{ route('welcome') }}`"
                    alt="{{ setting()->title[app()->getLocale() . '_title'] }}">
            </div>
            <div
                class="column @if (languages() != null && count(languages()) > 1) column-65 mobile_column-70 mini_mobile_column-50 @else column-75 mobile_column-70 mini_mobile_column-100 @endif menu_lists">
                <a class="menu_lists_item @yield('menu_welcome')" href="{{ route('welcome') }}">@lang('additional.urls.welcome')</a>
                @if (!empty(standartpages('about', 'type')))
                    <a class="menu_lists_item @yield('menu_about')"
                        href="{{ route('standartpages.show', standartpages('about', 'type')->slugs[app()->getLocale() . '_slug']) }}">{{ standartpages('about', 'type')->name[app()->getLocale() . '_name'] }}</a>
                @endif
                <a class="menu_lists_item @yield('menu_services')" href="{{ route('services.index') }}">@lang('additional.urls.services')</a>
                @guest
                    <a class="menu_lists_item @yield('menu_login')" href="{{ route('auth.login') }}">@lang('additional.urls.login')</a>
                    <a class="menu_lists_item @yield('menu_register')" href="{{ route('auth.register') }}">@lang('additional.urls.register')</a>
                @endguest
            </div>
            <div
                class="column @if (languages() != null && count(languages()) > 1) column-15 mobile_column-40 mini_mobile_column-20 @else @if (auth()->check()) column-5 mobile_column-20 mini_mobile_column-0 @else  column-5 mobile_column-20 mini_mobile_column-10 @endif @endif ">
                @auth
                    <div class="profil_section_on_header" id="profil_section_on_header">
                        @if(App\Helpers\Helper::getnotreadedmessagescount()>0) <span class="badge" style="position:absolute;top:0;right:0;background-color:red;border-radius:50%;width:25px;height:25px;display:inline-block;font-size:18px;text-align: center;color:#fff">{{App\Helpers\Helper::getnotreadedmessagescount()}}</span> @endif
                        <span class="profil_image"><img
                                src="@if (isset(auth()->user()->additionalinfo->company_image) && !empty(auth()->user()->additionalinfo->company_image)) {{ App\Helpers\Helper::getImageUrl(auth()->user()->additionalinfo->company_image, 'users') }} @else {{ asset('assets/images/no-user.png') }} @endif" /></span>
                        <ul class="dropdown_items">
                            <div class="profile_on_header" onclick="window.open(`{{ route('auth.profile') }}`)">


                                <div class="image_area">
                                    <img
                                        src="@if (isset(auth()->user()->additionalinfo->company_image) && !empty(auth()->user()->additionalinfo->company_image)) {{ App\Helpers\Helper::getImageUrl(auth()->user()->additionalinfo->company_image, 'users') }} @else {{ asset('assets/images/no-user.png') }} @endif" />
                                </div>
                                <div class="column_info">
                                    <h4>
                                        @if (isset(auth()->user()->additionalinfo->company_name) &&
                                                !empty(auth()->user()->additionalinfo->company_name) &&
                                                isset(auth()->user()->additionalinfo->company_name[app()->getLocale() . '_name']) &&
                                                !empty(auth()->user()->additionalinfo->company_name[app()->getLocale() . '_name']))
                                            {{ auth()->user()->additionalinfo->company_name[app()->getLocale() . '_name'] }}
                                        @else
                                            {{ auth()->user()->name_surname }}
                                        @endif

                                    </h4>
                                    <a herf="mailto:{{ auth()->user()->email }}">{{ auth()->user()->email }}</a>
                                </div>
                            </div>
                            @php
                                $routes = [
                                    [
                                        'name' => trans('additional.urls.orders'),
                                        'icon' => "<i class='las la-stream'></i>",
                                        'url' => route('orders.index'),
                                    ],
                                    [
                                        'name' => trans('additional.urls.payments'),
                                        'icon' => '<i class="las la-wallet"></i>',
                                        'url' => route('payments.index'),
                                    ],
                                    [
                                        'name' => trans('additional.urls.wishlist'),
                                        'icon' => '<i class="las la-bookmark"></i>',
                                        'url' => route('wishlist.index'),
                                    ],
                                    [
                                        'name' => trans('additional.urls.change_password'),
                                        'icon' => '<i class="las la-lock"></i>',
                                        'url' => route('settings.index'),
                                    ],
                                    [
                                        'name' => trans('additional.urls.logout'),
                                        'icon' => '<i class="las la-sign-out-alt"></i>',
                                        'url' => route('logout.index'),
                                    ],
                                ];
                            @endphp
                            @foreach ($routes as $route)
                                <li class="dropdown_items_list @yield($route['name'] . '_menu')"
                                    onclick="window.location.href=`{{ $route['url'] }}`">
                                    {!! $route['icon'] !!} {{ $route['name'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endauth

                @if (languages() != null && count(languages()) > 1)
                    <div class="dropdown_area">
                        <span class="current_locale">{{ app()->getLocale() }} <i
                                class="las la-chevron-down"></i></span>
                        <ul class="dropdown_items">
                            @foreach (languages() as $locale)
                                @if ($locale != app()->getLocale())
                                    <li class="dropdown_items_list"
                                        onclick="window.location.href=`{{ LaravelLocalization::getLocalizedURL($locale->name, null, [], true) }}`">
                                        {{ $locale->name }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>
</header>
