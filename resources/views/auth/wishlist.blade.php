@extends('layouts.app')
@section('title')
@if(!empty(lang_properties('wishlist','keyword'))) {{ lang_properties('wishlist','keyword')->name }} @else  @lang("additional.urls.wishlist") @endif
@endsection

@section('content')
    @include('auth.left_profile_tab')
    <section class="margin-y-10">
        <div class="w-75" style="margin:0 auto;">
            <div class="row">
                <h2 class="text-center w-100">@if(!empty(lang_properties('wishlist','keyword'))) {{ lang_properties('wishlist','keyword')->name }} @else  @lang("additional.urls.wishlist") @endif</h2>
            </div>
            <div class="row services" id="datas">
                @if (session()->has('bookmarks'))
                    @foreach (session()->get('bookmarks') as $element)
                        @php($product = product($element, true))
                        @if(!empty($product))
                            @include('services.service_element', ['data' => $product])
                        @endif
                    @endforeach
                @else
                    <p class="text-center w-100 text-danger">@lang('additional.pages.category.datanotfound')</p>
                @endif
            </div>
        </div>

    </section>

@endsection
