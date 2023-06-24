@extends('layouts.app')
@section('menu_payments', 'open')
@section('title', $data->uid)
@section('content')
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">{{ $data->transaction_id }} @lang("additional.forms.transaction_id")
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'payments',
                                    'harddelete' => false,
                                    'add' => false,
                                    'home' => true,
                                    'restoreall' => false,
                                ])</span>
                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang("additional.urls.dashboard")</a>
                            </li>
                            <li>
                                <a href="{{ route('payments.index') }}">@lang("additional.urls.payments")</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12 p-3 bg-white">
                @if ($data->data && $data->data != null && isset($data->data['name']) && !empty($data->data['name']))
                    <h1 class="py-4 px-3">@lang("additional.urls.service") @lang("additional.page_types.info")</h1>
                    <p class="d-block justify-space-evenly">

                    <h4 class="d-inline-block">{{ $data->data['name']['az_name'] }}</h4>
                    </p>
                @endif
                <br>
                @if ($data->from_id && $data->from_id != null)
                    <h1 class="py-4 px-3">Satıcı @lang("additional.page_types.info")</h1>
                    <p class="d-block justify-space-evenly">

                    <h4 class="d-inline-block">{{ users($data->from_id, 'id')->name_surname }}</h4>
                    <p> <a href="mailto:{{ users($data->from_id, 'id')->email }}"> {{ users($data->from_id, 'id')->email }}
                        </a> </p>
                    <p> <a href="tel:{{ users($data->from_id, 'id')->phone }}"> {{ users($data->from_id, 'id')->phone }} </a>
                    </p>
                    </p>
                @endif
                @if ($data->to_id && $data->to_id != null)
                    <h1 class="py-4 px-3">@lang("additional.urls.user") @lang("additional.page_types.info")</h1>
                    <p class="d-block justify-space-evenly">

                    <h4 class="d-inline-block">{{ users($data->to_id, 'id')->name_surname }}</h4>
                    <p> <a href="mailto:{{ users($data->to_id, 'id')->email }}"> {{ users($data->to_id, 'id')->email }} </a>
                    </p>
                    <p> <a href="tel:{{ users($data->to_id, 'id')->phone }}"> {{ users($data->to_id, 'id')->phone }} </a>
                    </p>
                    </p>
                @endif
                <br>
                <div class="w-100 p-3">
                    <h1 class="py-4 px-3">@lang("additional.urls.payment") @lang("additional.page_types.info")</h1>
                </div>
                <div class="row">
                    <pre>{!! $data->frompayment !!}</pre>
                </div>
            </div>

        </section>
    </section>
    <!-- END CONTENT -->
@endsection
