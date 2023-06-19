@extends('layouts.app')
@section('title')
    @lang('additional.urls.payments')
@endsection
@section('content')
    @include('auth.left_profile_tab')
    <section>
        <div class="container">
            <div class="row profile_heaader">
                <h1 class="w-100 text-center">@lang('additional.urls.payments')</h1>
            </div>
            <div class="row orders_page">
                <div class="w-100 profile_page_title">
                    <h2 class="page_title">@lang('additional.pages.payments.generalpayments')</h2>
                </div>
            </div>
            <div class="row payment_datas">
                @foreach ($data as $dat)
                    <div class="payment_widget">
                        <div class="icon"><i class="las la-money-bill"></i></div>
                        <div class="description">
                            <h5>{{ $dat->data['name'][app()->getLocale() . '_name'] ?? null }}</h5>
                            <p class="@if($dat->payment_status==1) success_payment_info @else error_payment_info  @endif" >@lang('additional.pages.payments.payment_status_' . $dat->payment_status)
                            </p>
                        </div>
                        <div class="price">{{ $dat->amount }}€</div>
                    </div>
                @endforeach
            </div>
            <br>
            {{ $data->links('layouts.partials.pagination', ['currentpage' => request()->page]) }}
        </div>
    </section>
@endsection
