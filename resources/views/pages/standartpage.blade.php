@extends('layouts.app')
@section('title')
    {{ $data->seo->name[app()->getLocale() . '_meta_title'] ?? $data->name[app()->getLocale() . '_name'] }}
@endsection

@section('description')
    {{ $data->seo->description[app()->getLocale() . '_meta_description'] ?? $data->description[app()->getLocale() . '_description'] }}
@endsection
@section('keywords')
    {{ $data->seo->keywords[app()->getLocale() . '_meta_keywords'] ?? $data->name[app()->getLocale() . '_name'] }}
@endsection
@section('image', App\Helpers\Helper::getImageUrl($data->image, 'standartpages') ?? null)
@if (isset($data) && !empty($data) && $data->type == 'about')
    @section('menu_about', 'active')
@endif
@section('content')
    @if (!empty($data->image))
        <section>
            <img class="lazyload blur-up" style="width:100%;height:100%;object-fit: contain;"
                data-src="{{ App\Helpers\Helper::getImageUrl($data->image, 'standartpages') ?? null }}" />
        </section>
    @endif
    <section>
        <div class="container">
            <div class="row">
                <div class="aboutpage column column-100 mobile_column-100 padding-y-30 padding-mobile-y-10">
                    <h1 class="text-center section_title">{{ $data->name[app()->getLocale() . '_name'] ?? null }}</h1>
                    <div
                    {{-- style="color:#969696;" --}}

                    class=" section_description">{!! $data->description[app()->getLocale() . '_description'] ?? null !!}</div>
                </div>
            </div>
        </div>
    </section>
@endsection
