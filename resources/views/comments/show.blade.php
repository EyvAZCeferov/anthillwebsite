@extends('layouts.app')
@section('menu_comments', 'open')
@section('title', 'Şərhlər')

@section('content')
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">Şərh
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
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
                            </li>
                            <li>
                                <a href="{{ route('comments.index') }}">Şərh</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12 p-3 bg-white" >
                    @if ($data->product && $data->product != null)
                        <h1 class="py-4 px-3">Xidmət Məlumatları</h1>
                        <p class="d-block justify-space-evenly">
                            
                        <h4 class="d-inline-block">{{ $data->product->name['az_name'] }}</h4>
                        </p>
                    @endif
                    <br>
                    @if ($data->user && $data->user != null)
                        <h1 class="py-4 px-3">İstifadəçi Məlumatları</h1>
                        <p class="d-block justify-space-evenly">

                        <h4 class="d-inline-block">{{ $data->user->name }} {{ $data->user->surname }}</h4>
                        <p> <a href="mailto:{{ $data->user->email }}"> {{ $data->user->email }} </a> </p>
                        <p> <a href="tel:{{ $data->user->phone }}"> {{ $data->user->phone }} </a> </p>
                        </p>
                    @endif
                    <br>
                    @if ($data && $data != null)
                        <h1 class="py-4 px-3">Komment Məlumatları</h1>
                        <p>Reytinq : {{ $data->rating }}</p>
                       
                        <p>
                            {{ $data->comment }}
                        </p>
                        <p>
                            Status : @if ($data->status == false)
                                <span class="bg-danger">Passiv</span>
                            @else
                                <span class="bg-success">Aktiv</span>
                            @endif
                        </p>
                    @endif
            </div>

        </section>
    </section>
    <!-- END CONTENT -->
@endsection
