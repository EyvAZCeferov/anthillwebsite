@extends('layouts.app')
@section('title')
    {{ $data->company_name[app()->getLocale() . '_name'] ?? null }}
@endsection
@section('description')
    {{ App\Helpers\Helper::strip_tags_with_whitespace($data->company_description[app()->getLocale() . '_description'] ?? null) }}
@endsection
@section('image', App\Helpers\Helper::getImageUrl($data->company_image, 'users') ?? null)

@section('content')
    @include('companies.company_section', ['data' => $data->user])
    <section>
        <div class="row">

            <div class="container">
                @if (!empty($data->user->products) && count($data->user->products) > 0)
                    <div class="tabs">
                        <div onclick="changetab('all')" class="tab all active">@lang('additional.pages.companies.all')</div>
                        @foreach (App\Helpers\Helper::getusercats($data->user_id) as $category)
                            <div onclick="changetab('{{ $category->slugs[app()->getLocale() . '_slug'] }}')"
                                class="tab {{ $category->slugs[app()->getLocale() . '_slug'] }}"
                                id="{{ $category->name[app()->getLocale() . '_name'] }}">
                                {{ $category->name[app()->getLocale() . '_name'] }}</div>
                        @endforeach
                    </div>
                @endif
                <div class="tab_elements">
                    <div class="tab_element active services" id="all">
                        @if (!empty($data->user->products) && count($data->user->products) > 0)
                            @foreach ($data->user->products as $product)
                                @include('services.service_element', ['data' => $product])
                            @endforeach

                        @endif
                    </div>

                    @foreach (App\Helpers\Helper::getusercats($data->user_id) as $category)
                        <div class="tab_element services" id="{{ $category->slugs[app()->getLocale() . '_slug'] }}">
                            @foreach ($data->user->products->where('category_id', $category->id) as $product)
                                @include('services.service_element', ['data' => $product])
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
