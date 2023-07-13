<div class="service_one column-28 mobile_column-45" id="service-{{ $data->code }}">
    @if (isset($data->user) &&
            !empty($data->user) &&
            $data->user->type==3 &&
            !empty($data->user->additionalinfo) &&
            isset($data->user->additionalinfo->company_image) &&
            !empty($data->user->additionalinfo->company_image))
        <div class="company_area"
            onclick="window.open(`{{ route('companies.show', $data->user->additionalinfo->company_slugs[app()->getLocale() . '_slug']) }}`)">
            <img class="lazyload blur-up" data-src="{{ App\Helpers\Helper::getImageUrl($data->user->additionalinfo->company_image, 'users') }}" />
        </div>
    @endif
    @if (auth()->check())
        @if (auth()->user()->id == $data->user_id)
            <div class="more">
                <span class="more_button" onclick="toggledropdowforcreator(`{{$data->code}}`)"><i class="las la-ellipsis-v"></i></span>
                <div class="dropdown">
                    <div class="dropdown_element" onclick="deletequeryservice(`{{ $data->code }}`,`{{ $data->user_id }}`,'@lang('additional.messages.areyousuredelete')','{{ app()->getLocale() }}')">
                        <i class="las la-trash"></i> @lang('additional.buttons.delete')
                    </div>
                    <div class="dropdown_element" onclick="window.location.href=`{{ route('services.edit',['code'=>$data->code]) }}`">
                        <i class="las la-undo-alt"></i> @lang('additional.buttons.update')
                    </div>
                    <div class="dropdown_element" onclick="createpaymentlink(`{{ $data->code }}`,'{{ auth()->user()->id }}','{{ app()->getLocale() }}',false)">
                        <i class="las la-link"></i> @lang('additional.buttons.createlink')
                    </div>
                    <div class="dropdown_element" onclick="toggledropdowforcreator(`{{$data->code}}`)">
                        <i class="las la-arrow-left"></i> @lang("additional.buttons.back")
                    </div>
                </div>
            </div>
        @else
            <div class="bookmark @if (auth()->check() && !empty(wishlist_items(auth()->id(),$data->id))) active @endif"
                onclick="bookmarktoggle('{{ $data->code }}','{{ app()->getLocale() }}','{{ route('api.bookmarktoggle') }}')">
                <i class="@if (auth()->check() && !empty(wishlist_items(auth()->id(),$data->id))) fas fa-bookmark @else las la-bookmark @endif "></i></div>
        @endif
    @else
        <div class="bookmark @if (auth()->check() && !empty(wishlist_items(auth()->id(),$data->id))) active @endif"
            onclick="bookmarktoggle('{{ $data->code }}','{{ app()->getLocale() }}','{{ route('api.bookmarktoggle') }}')">
            <i class="@if (auth()->check() && !empty(wishlist_items(auth()->id(),$data->id))) fas fa-bookmark @else las la-bookmark @endif "></i></div>
    @endif
    @if (isset($data->images[0]) && !empty($data->images[0]))
        <div class="image_area"
            onclick="window.open(`{{ route('services.show', $data->slugs[app()->getLocale() . '_slug']) }}`)">
            <img class="lazyload blur-up" data-src="{{ App\Helpers\Helper::getImageUrl($data->images[0]->original_images, 'products') }}"
                alt="{{ $data->name[app()->getLocale() . '_name'] }}">
        </div>
    @endif
    <h4 class="name text-center" onclick="window.open(`{{ route('services.show', $data->slugs[app()->getLocale() . '_slug']) }}`)">
        {{ $data->name[app()->getLocale() . '_name'] }}</h4>
    <p class="descriptive"
        onclick="window.open(`{{ route('services.show', $data->slugs[app()->getLocale() . '_slug']) }}`)">
        {!! mb_substr(
            App\Helpers\Helper::strip_tags_with_whitespace($data->description[app()->getLocale() . '_description']),
            0,
            70
        ) !!}</p>
    @if (App\Helpers\Helper::getstars($data->code) != 0)
    @php($ratings = App\Helpers\Helper::getstarswithdetail($data->code))

        <div class="stars"
        style="margin:0;"
            onclick="window.open(`{{ route('services.show', $data->slugs[app()->getLocale() . '_slug']) }}`)">
            @for ($i = 0; $i < 5; $i++)

                <div class="star"><i class="@if (App\Helpers\Helper::getstars($data->code) <= $i) lar @else las @endif la-star"></i>
                </div>
            @endfor
        </div>
    @endif



    <hr onclick="window.open(`{{ route('services.show', $data->slugs[app()->getLocale() . '_slug']) }}`)" />
    <p class="price" onclick="window.open(`{{ route('services.show', $data->slugs[app()->getLocale() . '_slug']) }}`)"><span style="font-size:12px;color:gray;font-weight:bold">Starts at</span>
        {{ $data->price ?? 0 }}<span class="symbol">€</span></p>

</div>
