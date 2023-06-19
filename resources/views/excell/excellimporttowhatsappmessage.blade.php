@extends('layouts.app')

@section('title', 'Məhsulları daxil et (toplu)')

@section('content')
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">Məktub göndər
                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
                            </li>
                            <li>
                                <a href="{{ route('excellimportPage') }}">Məktub göndər</a>
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
                            <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">


                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label for="ecxcell">Excell File</label>
                                        <input id="excell" type="file" placeholder="Excell File" class="form-control"
                                            name="excell">
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label for="images">Text</label>
                                        <textarea class="form-control ckeditor" name="message" rows="6"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <br>

                                    <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-primary">Təsdiq et</button>
                                            <a type="button" href="{{ route('excellimportPage') }}" class="btn">Ləğv
                                                et</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>

        </section>
    </section>
@endsection
