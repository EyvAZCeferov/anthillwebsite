<div class="row author_area">
    @if (isset($data->additionalinfo->company_name[app()->getLocale() . '_name']))
        <div class="author_icon_and_name"
            onclick="window.location.href=`{{ route('companies.show', $data->additionalinfo->company_slugs[app()->getLocale() . '_slug']) }}`">
            <div class="image"><img class="lazyload blur-up" draggable="false"
                    data-src="{{ App\Helpers\Helper::getImageUrl($data->additionalinfo->company_image, 'users') ?? asset('assets/images/no-user.png') }}"
                    alt="{{ $data->additionalinfo->company_name[app()->getLocale() . '_name'] }}"></div>
            <h4 class="name">
                {{ $data->additionalinfo->company_name[app()->getLocale() . '_name'] ?? $data->name_surname }}</h4>
        </div>
    @endif
    @if (App\Helpers\Helper::getstars($product->code) != 0)
        <div class="stars" style="margin:0;">
            @for ($i = 0; $i < 5; $i++)
                <div class="star"><i class="@if (App\Helpers\Helper::getstars($product->code) <= $i) lar @else las @endif la-star"></i>
                </div>
            @endfor
        </div>
    @endif
</div>
