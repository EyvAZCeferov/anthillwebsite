@extends('layouts.app')
@section('title')
    @lang('additional.urls.orders')
@endsection
@section('content')
    @include('auth.left_profile_tab')
    <section>
        <div class="container">
            <div class="row profile_heaader">
                <h1 class="w-100 text-center">@lang('additional.urls.orders')</h1>
            </div>
            <div class="row orders_page">
                <div class="w-100 profile_page_title">
                    <h2 class="page_title">@lang('additional.pages.payments.generalorders')</h2>
                </div>
                <div class="w-100 table">
                    <table>
                        <thead>
                            <tr>
                                <th>@lang('additional.pages.payments.table.servicename')</th>
                                <th>@lang('additional.forms.price')</th>
                                <th>@lang('additional.pages.payments.table.orderdate')</th>
                                <th>@lang('additional.pages.payments.table.status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $dat)
                                <tr onclick="window.location.href=`{{ route('orders.show',['uid'=>$dat->uid]) }}`">
                                    <td>
                                        {{ $dat->product->name[app()->getLocale() . '_name'] }}
                                    </td>
                                    <td>
                                        {{ $dat->price }}€
                                    </td>
                                    <td>
                                        {{ $dat->created_at!=null ? App\Helpers\Helper::getDateTimeViaTimeStamp($dat->created_at,false) :null }}
                                    </td>
                                    <td>
                                        @lang('additional.pages.payments.status_' . $dat->status)
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
                {{ $data->links('layouts.partials.pagination',['currentpage'=>request()->page]) }}
            </div>
        </div>
    </section>
    <br />
@endsection
