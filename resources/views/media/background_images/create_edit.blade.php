@extends('layouts.app')
@section('menu_media', 'open')
@section('title')
    @if (isset($data) && !empty($data))
        Arxafon şəkli yenilə
    @else
        Arxafon şəkli əlavə et
    @endif
@endsection

@section('content')
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">
                            @if (isset($data) && !empty($data))
                                 Arxafon şəkli yenilə
                            @else
                                Arxafon şəkli əlavə et
                            @endif
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'background_images',
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
                                <a href="{{ route('background_images.index') }}">Arxafon şəkli</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>


            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <section class="box ">
                    <header class="panel_header">
                        <div class="actions panel_actions pull-right">
                            <i class="box_toggle fa fa-chevron-down"></i>
                            <i class="box_close fa fa-times"></i>
                        </div>
                    </header>
                    <div class="content-body">
                        <div class="row">
                            <form
                                @if (isset($data) && !empty($data)) action="{{ route('background_images.update', $data->id) }}" @else action="{{ route('background_images.store') }}" @endif
                                method="post" enctype="multipart/form-data">
                                @csrf

                                @if (isset($data) && !empty($data))
                                    @method('PUT')
                                @endif

                             

                                <div class="row">
                                   

                                    <div class="col-sm-12 col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">Şəkil</label>
                                            @if (isset($data) && !empty($data) && !empty($data->image))
                                                <img width="125" src="{{ asset('/uploads/bgimages/' . $data->image) }}">
                                            @endif
                                            <div class="controls">
                                                <input type="file" class="form-control" name="image">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label"> Tip</label>
                                            <div class="controls">
                                                <select name="type" required class="form-control">
                                                   @foreach($pages as $page)
                                                        <option value="{{$page}}"
                                                            @if (isset($data) && !empty($data) && isset($data->type) && $data->type == $page) selected @endif>
                                                            {{$page}}</option>
                                                    @endforeach                                                   
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                   

                                </div>

                                <br>

                                <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                    <div class="text-left">
                                        <button type="submit" class="btn btn-primary">Təsdiq et</button>
                                        <a type="button" href="{{ route('background_images.index') }}" class="btn">Ləğv
                                            et</a>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                </section>
            </div>

        </section>
    </section>
    <!-- END CONTENT -->
@endsection