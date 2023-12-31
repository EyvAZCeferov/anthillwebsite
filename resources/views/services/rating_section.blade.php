<div class="rating_content">
    <div class="total_rating_andreview_text">
        <div class="total_rating">{{ floatval(App\Helpers\Helper::getstars($data->code)) }}</div>

        @if (App\Helpers\Helper::getstars($data->code) != 0)
            <div class="stars" style="margin:0;">
                @for ($i = 0; $i < 5; $i++)
                    <div class="star"><i class="@if (App\Helpers\Helper::getstars($data->code) <= $i) lar @else las @endif la-star"></i>
                    </div>
                @endfor
            </div>
        @endif
        <span class="comment_count" onclick="scrolltocommentarea()">@lang('additional.pages.services.reviewcount', ['count' => count($comments)])</span>
    </div>
    <div class="rating_elements">
        @if (App\Helpers\Helper::getstars($data->code) != 0)
            @php($ratings = App\Helpers\Helper::getstarswithdetail($data->code))
            @for ($i = 5; $i >= 1; $i--)
                <div class="rating_elements_one">
                    <span class="rating_key">{{ $i }}</span>
                    @php($division = floatval(floatval($ratings[$i]) / floatval($ratings['ratings'])))
                    <span class="rating_value">
                        <span class="rating_value_element" @if ($division == 0) style="width:1%" @else
                        style="width:{{ floatval($division) * 100 }}%;" @endif ></span>
                    </span>
                </div>
            @endfor
        @endif

    </div>
    <div class="bookmarkandcommentarea">
        <button
            onclick="bookmarktoggle('{{ $data->code }}','{{ app()->getLocale() }}','{{ route('api.bookmarktoggle') }}')"
            class="bookmark @if (auth()->check() && !empty(wishlist_items(auth()->id(),$data->id))) active @endif"> <i class="las la-bookmark"></i>
            <span class="@if (auth()->check() && !empty(wishlist_items(auth()->id(),$data->id))) active @endif">
                @lang('additional.buttons.bookmark')
            </span>
        </button>
        <button onclick="scrolltocommentarea()"><i class="las la-comment"></i> @lang('additional.buttons.writeareview')</button>
    </div>
</div>
