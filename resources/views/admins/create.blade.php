@extends('layouts.app')
@section('menu_admins', 'open')
@section('title')
    @lang("additional.urls.admins") @lang("additional.page_types.create")
@endsection
@section('content')

    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">@lang("additional.urls.admins") @lang("additional.page_types.create")
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'admins',
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
                                <a href="{{ route('admins.index') }}">@lang("additional.urls.admins") @lang("additional.page_types.create")</a>
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
                            <form action="{{ route('admins.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">

                                        <div class="form-group">
                                            <label class="form-label">@lang("additional.forms.name_surname")</label>
                                            <div class="controls">
                                                <input type="text" value="" class="form-control" name="name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">

                                        <div class="form-group">
                                            <label class="form-label">@lang("additional.forms.email")</label>
                                            <div class="controls">
                                                <input type="text" value="" class="form-control" name="email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">

                                        <div class="form-group">
                                            <label class="form-label">@lang("additional.forms.phone")</label>
                                            <div class="controls">
                                                <input type="text" value="" class="form-control" name="phone">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

                                        <div class="form-group">
                                            <label class="form-label">@lang("additional.forms.password")</label>
                                            <div class="controls">
                                                <input type="text" value="" class="form-control" name="password">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

                                        <div class="form-group">
                                            <label class="form-label">@lang("additional.forms.password_confirmation")</label>
                                            <div class="controls">
                                                <input type="text" value="" class="form-control"
                                                    name="password_confirmation">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

                                        <div class="form-group">
                                            <label class="form-label">@lang("additional.forms.role")</label>
                                            <div class="controls">
                                                <select name="role_id" class="form-control">
                                                    @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <h3>@lang("additional.urls.permissions")</h3>
                                <div class="row">
                                    @foreach ($permissions as $key => $value)
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <input type="checkbox" name="permissions[{{ $value->name }}]"
                                                    id="permission-{{ $key }}" checked>
                                                <label for="permission-{{ $key }}">{{ $value->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <br>

                                <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                    <div class="text-left">
                                        <button type="submit" class="btn btn-primary">@lang("additional.buttons.submit")</button>
                                        <a type="button" href="{{ route('admins.index') }}" class="btn">@lang("additional.buttons.cancel")</a>
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
