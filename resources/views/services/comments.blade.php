<section id="commentarea">
    <div class="row">
        <h3 class="tab_section_title">@lang('additional.pages.services.comments', ['count' => count($comments)])</h3>
    </div>
    <div class="row comments">
        <div id="newcomment"></div>
        @foreach ($comments->where('status',true) as $comment)
            <div class="comment">
                <div class="image">
                    <img data-src="@if (!empty($comment->user->additionalinfo) && isset($comment->user->additionalinfo->company_image) && !empty($comment->user->additionalinfo->company_image)) {{ App\Helpers\Helper::getImageUrl($comment->user->additionalinfo->company_image, 'users') }} @else {{ asset('assets/images/no-user.png') }} @endif"
                        alt="{{ $comment->user->name_surname }}" class="lazyload blur-up">
                </div>
                <div class="info">
                    <h3 class="name">{{ $comment->user->name_surname }}</h3>
                    @if ($comment->rating != 0)
                        <div class="stars">
                            @for ($i = 1; $i < 6; $i++)
                                <div class="star"><i
                                        class="@if ($comment->rating == $i) lar @else las @endif la-star"></i>
                                </div>
                            @endfor
                        </div>
                    @endif
                    <p class="description">{!! $comment->comment !!}</p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row newcommentwrite">
        @if (auth()->check())
            <form class="margin-y-20" onsubmit="formsend()" id="formsend">
                <div id="messages"></div>
                @csrf
                <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                <input type="hidden" name="user_id" value="{{auth()->user()->id}}" />
                <input type="hidden" name="product_id" value="{{ $data->id }}" />
                <div class="row">
                    <div class="image">
                        <img alt="{{ auth()->user()->name_surname }}"
                            data-src="@if (isset(auth()->user()->additionalinfo->company_image) && !empty(auth()->user()->additionalinfo->company_image)) {{ App\Helpers\Helper::getImageUrl(auth()->user()->additionalinfo->company_image, 'users') }} @else {{ asset('assets/images/no-user.png') }} @endif"
                            class="lazyload blur-up"
                            />
                    </div>
                    <div class="info ">
                        <div class="yildizlar">
                            @for ($i = 1; $i < 6; $i++)
                                <input type="radio" id="yildiz{{ $i }}" name="yildiz" value="{{ $i }}" />
                                <label class="star" for="yildiz{{ $i }}" title="Awesome" aria-hidden="true"><i class="las la-star"></i></label>
                            @endfor
                        </div>
                        <div class="form-group height-auto">
                            <textarea name="message" class="form-control" rows="10" placeholder="@lang("additional.forms.shareyourcomment")" ></textarea>
                        </div>
                    </div>

                </div>
                <div class="button_send_area">
                    <button class="submit" type="submit" >@lang("additional.buttons.sharecomment")</button>
                </div>
            </form>
        @else
            <p>@lang('additional.pages.services.ifyoucommentpleaselogin', ['page' => trans('additional.urls.login'), 'url' => route('auth.login')])</p>
        @endif
    </div>
</section>



