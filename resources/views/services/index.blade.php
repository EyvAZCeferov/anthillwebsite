@extends('layouts.app')

@section('title')
    @if(!empty(standartpages('services','type')))
        {{standartpages('services','type')->seo->name[app()->getLocale().'_meta_title']}}
    @else
        @lang('additional.urls.services')
    @endif
@endsection
@section('description')
    @if(!empty(standartpages('services','type')))
        {{standartpages('services','type')->seo->description[app()->getLocale().'_meta_description']}}
    @else
        @lang('additional.urls.services')
    @endif
@endsection
@section('keywords')
    @if(!empty(standartpages('services','type')))
        {{standartpages('services','type')->seo->keywords[app()->getLocale().'_meta_keywords']}}
    @else
        @lang('additional.urls.services')
    @endif
@endsection

@section('menu_services', 'active')

@section('content')
    @include('services.search_filter',['type'=>'services'])
    @include('services.categories',['type'=>'services','selected_category'=>$category])
    <section class="margin-y-10">
        <div class="w-75 datasonshow" style="margin:0 auto;">
            <div class="row">
                <h2 class="text-center w-100">@lang('additional.urls.services')</h2>
            </div>

            <div class="row w-100 view_button_area" style="justify-content: flex-end;">
                <button onclick="togglepopup('filter_views')" class="viewbutton">@lang('additional.pages.category.view')</button>
                <div class="filter_views" id="filter_views">
                    <div class="w-100 close_button_area">
                        <span onclick="togglepopup('filter_views')"><i class="las la-times"></i></span>
                    </div>
                    <div class="filter_view asc" onclick="change_filter('asc','datas','{{ app()->getLocale() }}','services')">
                        <i class="las la-sort-alpha-down"></i>
                        @lang('additional.pages.category.atozalphabetic')
                    </div>
                    <div class="filter_view desc" onclick="change_filter('desc','datas','{{ app()->getLocale() }}','services')">
                        <i class="las la-sort-alpha-up"></i>
                        @lang('additional.pages.category.ztoalphabetic')
                    </div>
                    <div class="filter_view random" onclick="change_filter('random','datas','{{ app()->getLocale() }}','services')">
                        <i class="las la-random"></i>
                        @lang('additional.pages.category.random')
                    </div>
                    <div class="filter_view priceasc" onclick="change_filter('priceasc','datas','{{ app()->getLocale() }}','services')">
                        <i class="las la-sort-amount-down-alt"></i>
                        @lang('additional.pages.category.forpriceasc')
                    </div>
                    <div class="filter_view pricedesc" onclick="change_filter('pricedesc','datas','{{ app()->getLocale() }}','services')">
                        <i class="las la-sort-amount-up-alt"></i>
                        @lang('additional.pages.category.forpricedesc')
                    </div>
                </div>
            </div>
            <br/>

            <div class="row services" id="datas">
                @if (count($products) > 0)
                    @foreach ($products as $product)
                        @include('services.service_element', ['data' => $product])
                    @endforeach
                @else
                    <p class="text-center w-100 text-danger">@lang('additional.pages.category.datanotfound')</p>
                @endif
            </div>
        </div>
    </section>
    <br/>
@endsection
