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

                @if (auth()->check() && !empty(wishlist_items(auth()->id())) && count(wishlist_items(auth()->id()))>0)
                    @foreach (wishlist_items(auth()->id()) as $element)
                        @php($product = App\Models\Products::where('id',$element->product_id)->with(['attributes', 'category',  'user', 'images', 'comments'])->first())

                        @if(!empty($product))
                            @include('services.service_element', ['data' => $product,'pagetype'=>'wishlist'])
                        @endif
                    @endforeach
                @else
                    <p class="text-center w-100 text-danger">@lang('additional.pages.category.datanotfound')</p>
                @endif
            </div>
        </div>

    </section>

@endsection
