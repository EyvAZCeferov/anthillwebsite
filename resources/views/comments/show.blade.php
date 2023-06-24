@extends('layouts.app')
@section('menu_comments', 'open')
@section('title', trand("additional.urls.comments"))

@section('content')
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">@lang("additional.urls.comment")
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'comments',
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
                                <a href="{{ route('comments.index') }}">@lang("additional.urls.comment")</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12 p-3 bg-white" >
                    @if ($data->product && $data->product != null)
                        <h1 class="py-4 px-3">@lang("additional.urls.comment") @lang("additional.page_types.info")</h1>
                        <p class="d-block justify-space-evenly">
                            
                        <h4 class="d-inline-block">{{ $data->product->name['az_name'] }}</h4>
                        </p>
                    @endif
                    <br>
                    @if ($data->user && $data->user != null)
                        <h1 class="py-4 px-3">@lang("additional.urls.user") @lang("additional.page_types.info")</h1>
                        <p class="d-block justify-space-evenly">

                        <h4 class="d-inline-block">{{ $data->user->name }} {{ $data->user->surname }}</h4>
                        <p> <a href="mailto:{{ $data->user->email }}"> {{ $data->user->email }} </a> </p>
                        <p> <a href="tel:{{ $data->user->phone }}"> {{ $data->user->phone }} </a> </p>
                        </p>
                    @endif
                    <br>
                    @if ($data && $data != null)
                        <h1 class="py-4 px-3">@lang("additional.urls.comment") @lang("additional.page_types.info")</h1>
                        <p>@lang("additional.forms.rating") : {{ $data->rating }}</p>
                       
                        <p>
                            {{ $data->comment }}
                        </p>
                        <p>
                            Status : @if ($data->status == false)
                                <span class="bg-danger">@lang("additional.forms.statuses.passive")</span>
                            @else
                                <span class="bg-success">@lang("additional.forms.statuses.active")</span>
                            @endif
                        </p>
                    @endif
            </div>

        </section>
    </section>
    <!-- END CONTENT -->
@endsection
