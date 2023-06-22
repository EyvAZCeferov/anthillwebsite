<footer class="main_footer">
    <div class="container">
        <div class="row padding-y-40 padding-mobile-y-15">
            <div class="column column-33 mobile_column-50 left_writes">
                <img
                src="{{ App\Helpers\Helper::getImageUrl(setting()->logo, 'settings') }}" 
                class="brend-image"
                    onclick="window.location.href=`{{ route('welcome') }}`"
                    alt="{{ setting()->title[app()->getLocale() . '_title'] }}">
                <p>{{ setting()->description[app()->getLocale() . '_description'] }}</p>

                {{--@if (isset(setting()->social_media['mobile_phone']) && !empty(setting()->social_media['mobile_phone']))
                    <p>@lang('additional.footer.columns.mobilephone', ['phone' => setting()->social_media['mobile_phone']])</p>
                @endif--}}
                @if (isset(setting()->social_media['email']) && !empty(setting()->social_media['email']))
                    <p>@lang('additional.footer.columns.email', ['email' => setting()->social_media['email']])</p>
                @endif

                <p class="social_media" style="font-size:24px">
                    @if (isset(setting()->social_media['facebook_url']) && !empty(setting()->social_media['facebook_url']))
                        <a href="{{ setting()->social_media['facebook_url'] }}" target="_blank"
                            referrerpolicy="no-referrer"><i class="lab la-facebook"></i></a>
                    @endif
                    @if (isset(setting()->social_media['instagram_url']) && !empty(setting()->social_media['instagram_url']))
                        <a href="{{ setting()->social_media['instagram_url'] }}" target="_blank"
                            referrerpolicy="no-referrer"><i class="lab la-instagram"></i></a>
                    @endif
                    @if (isset(setting()->social_media['youtube_url']) && !empty(setting()->social_media['youtube_url']))
                        <a href="{{ setting()->social_media['youtube_url'] }}" target="_blank"
                            referrerpolicy="no-referrer"><i class="lab la-twitter"></i></a>
                    @endif

                </p>

            </div>
            <div class="column column-33 mobile_column-50">
                <h3 class="footer_heading text-center">@lang('additional.footer.pages')</h3>
                <hr class="green_hr">
                <ul class="menu_items_lists">

                    @if (!empty(standartpages('about','type')))
                    <li onclick="window.location.href='{{ route('standartpages.show', standartpages('about','type')->slugs[app()->getLocale() . '_slug']) }}'"
                            class="menu_items_lists_item text-center">
                            {{ standartpages('about','type')->name[app()->getLocale() . '_name'] }}</li>
                    @endif

                    <li onclick="window.location.href='{{ route('services.index') }}'"
                        class="menu_items_lists_item text-center">
                        @lang('additional.urls.services')
                    </li>
                    <li onclick="window.location.href='{{ route('companies.index') }}'"
                        class="menu_items_lists_item text-center">
                        @lang('additional.urls.companies')
                    </li>
                    <li onclick="window.location.href='{{ route('wishlist.index') }}'"
                        class="menu_items_lists_item text-center">
                        @lang('additional.urls.wishlist')
                    </li>

                </ul>

            </div>
            <div class="column column-33 mobile_column-50">
                <h3 class="footer_heading text-center">@lang('additional.footer.legal')</h3>
                <hr class="green_hr">
                <ul class="menu_items_lists">
                    @foreach (standartpages() as $page)
                        @if($page->type=="termofuse" || $page->type=="privarcypolicy" || $page->type=="cancellationandrefundpolicy")
                            <li onclick="window.location.href='{{ route('standartpages.show', $page->slugs[app()->getLocale() . '_slug']) }}'"
                                class="menu_items_lists_item text-center">
                                {{ $page->name[app()->getLocale() . '_name'] }}</li>
                        @endif

                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @if (
        !empty(setting()->social_media) &&
            isset(setting()->social_media['log_enabled']) &&
            !empty(setting()->social_media['log_enabled']) &&
            setting()->social_media['log_enabled'] == 'active')
        <div class="row text-center copyright">
            @lang('additional.footer.copyright')
        </div>
    @endif
</footer>
