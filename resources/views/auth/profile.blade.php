@extends('layouts.app')
@section('title')
    @if (isset($data->additionalinfo) &&
            !empty($data->additionalinfo) &&
            isset($data->additionalinfo[app()->getLocale() . '_name']) &&
            !empty($data->additionalinfo[app()->getLocale() . '_name']))
        {{ $data->additionalinfo->company_name[app()->getLocale() . '_name'] }}
    @else
        {{ $data->name_surname??null }}
    @endif
@endsection
@section('description')
    {{ App\Helpers\Helper::strip_tags_with_whitespace($data->additionalinfo->company_description[app()->getLocale() . '_description'] ?? null) }}
@endsection
@section('image', App\Helpers\Helper::getImageUrl($data->additionalinfo->company_image, 'users') ?? null)
@section('profile_menu', 'active')

@section('content')
    @include('auth.left_profile_tab')
    <section>
        <div class="container">
            <div class="row profile_heaader">
                <h1 class="w-100 text-center">@lang('additional.urls.profile')</h1>
            </div>
            @php
                $routes = [];
                if (auth()->user()->type == 3) {
                    array_push($routes, [
                        'name' => trans('additional.urls.myservices'),
                        'icon' => '<i class="las la-cube"></i>',
                        'url' => route('myservices.index'),
                        'count' => !empty($data->products) ? count($data->products) : ' 0 ',
                        'type' => 'company',
                    ]);
                }
                $routes_2 = [
                    [
                        'name' => trans('additional.urls.wishlist'),
                        'icon' => '<i class="las la-bookmark"></i>',
                        'url' => route('wishlist.index'),
                        'count' => !empty(session()->get('bookmarked')) ? count(session()->get('bookmarked')) : ' 0 ',
                    ],
                    [
                        'name' => trans('additional.urls.payments'),
                        'icon' => '<i class="las la-file-invoice-dollar"></i>',
                        'url' => route('payments.index'),
                        'count' => !empty($data->orders) ? App\Helpers\Helper::sumpayments($data->orders) : ' 0 ',
                    ],
                    [
                        'name' => trans('additional.urls.messages'),
                        'icon' => '<i class="las la-sms"></i>',
                        'url' => route('messages.index'),
                        'count' => !empty($data->messages) ? count($data->messages) : ' 0 ',
                    ],
                    [
                        'name' => trans('additional.urls.orders'),
                        'icon' => '<i class="las la-folder-open"></i>',
                        'url' => route('orders.index'),
                        'count' => !empty($data->orders) ? count($data->orders) : ' 0 ',
                    ],
                    [
                        'name' => trans('additional.urls.settings'),
                        'icon' => '<i class="las la-cog"></i>',
                        'url' => route('settings.index'),
                        'count' => null,
                    ],
                ];
                $routes = array_merge($routes, $routes_2);
            @endphp

            <div class="row profile-widgets">
                @foreach ($routes as $route)
                    <div class="profile-widget" onclick="window.location.href='{{ $route['url'] }}'">
                        <div class="info">
                            {!! $route['icon'] !!}
                            <h4>{{ $route['name'] }}</h4>
                        </div>

                        <span class="count">
                            @if (!empty($route['count']))
                                {{ $route['count'] ?? 0 }}
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <br>
@endsection
