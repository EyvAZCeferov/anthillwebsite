@if (auth()->check())
    <div class="left_profile_tab">
        <div class="element" onclick="window.location.href=`{{ route('welcome') }}`">
            <img data-src="{{ App\Helpers\Helper::getImageUrl(setting()->icon, 'settings') }}"

                onclick="window.location.href=`{{ route('welcome') }}`" class="little_logo lazyload blur-up"
                alt="{{ setting()->title[app()->getLocale() . '_title'] }}" />
            <img data-src="{{ App\Helpers\Helper::getImageUrl(setting()->logo, 'settings') }}"
                onclick="window.location.href=`{{ route('welcome') }}`" class="big_logo lazyload blur-up"
                alt="{{ setting()->title[app()->getLocale() . '_title'] }}" />
        </div>
        @if (auth()->user()->type == 3)
            <div class="element @yield('addservice_menu') " onclick="window.location.href=`{{ route('services.addnew') }}`">
                <i class="las la-plus-circle"></i> <span>@lang('additional.urls.addservice')</span>
            </div>
        @endif
        <div class="element @yield('orders_menu')" onclick="window.location.href=`{{ route('orders.index') }}`">
            <i class="las la-folder-open"></i> <span>@lang('additional.urls.orders')</span>
        </div>
        <div class="element @yield('wishlist_menu')" onclick="window.location.href=`{{ route('wishlist.index') }}`">
            <i class="las la-bookmark"></i> <span>@if(!empty(lang_properties('wishlist','keyword'))) {{ lang_properties('wishlist','keyword')->name }} @else  @lang("additional.urls.wishlist") @endif</span>
        </div>
        <div class="element @yield('messages_menu')" onclick="window.location.href=`{{ route('messages.index') }}`">
            <i class="las la-sms"></i> <span>@lang('additional.urls.messages')</span>
        </div>
        <div class="element @yield('payments_menu')" onclick="window.location.href=`{{ route('payments.index') }}`">
            <i class="las la-file-invoice-dollar"></i> <span>@lang('additional.urls.payments')</span>
        </div>
        @if (auth()->user()->type == 3)
            <div class="element @yield('myservices_menu')" onclick="window.location.href=`{{ route('myservices.index') }}`">
                <i class="las la-cube"></i> <span>@lang('additional.urls.myservices')</span>
            </div>
        @endif
        <hr>

        <div class="element @yield('settings_menu')" onclick="window.location.href=`{{ route('settings.index') }}`">
            <i class="las la-cog"></i> <span>@lang('additional.urls.settings')</span>
        </div>
        <div class="element @yield('logout_menu')" onclick="window.location.href=`{{ route('logout.index') }}`">
            <i class="las la-sign-out-alt"></i> <span>@lang('additional.urls.logout')</span>
        </div>
        <div class="element profile @yield('profile_menu')" onclick="window.location.href=`{{ route('auth.profile') }}`">
            <img data-src="@if (isset(auth()->user()->additionalinfo->company_image) && !empty(auth()->user()->additionalinfo->company_image)) {{ App\Helpers\Helper::getImageUrl(auth()->user()->additionalinfo->company_image, 'users') }} @else {{ asset('assets/images/no-user.png') }} @endif"
                onclick="window.location.href=`{{ route('auth.profile') }}`"  class="lazyload blur-up"/>
            <span class="profil_name_surname">{{ auth()->user()->name_surname }}</span>
        </div>
    </div>
@endif
