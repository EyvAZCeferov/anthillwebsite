@extends('layouts.app')
@section('menu_admins', 'open')
@section('title', $data->name_surname . ' düzəliş et')
@section('content')

    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">{{ $data->name_surname }} düzəliş et
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
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
                            </li>
                            <li>
                                <a href="{{ route('admins.index') }}">{{ $data->name }} düzəliş et</a>
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
                            <form action="{{ route('admins.update', $data) }}" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">

                                        <div class="form-group">
                                            <label class="form-label">Ad Soyad</label>
                                            <div class="controls">
                                                <input type="text" value="{{ $data->name_surname }}" class="form-control"
                                                    name="name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">

                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <div class="controls">
                                                <input type="text" value="{{ $data->email }}" class="form-control"
                                                    name="email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">

                                        <div class="form-group">
                                            <label class="form-label">Telefon</label>
                                            <div class="controls">
                                                <input type="text" value="{{ $data->phone }}" class="form-control"
                                                    name="phone">
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                        <div class="form-group">
                                            <label class="form-label">Şifrə</label>
                                            <div class="controls">
                                                <input type="text" value="" class="form-control" name="password">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                        <div class="form-group">
                                            <label class="form-label">Şifrə Təsdiqi</label>
                                            <div class="controls">
                                                <input type="text" value="" class="form-control"
                                                    name="password_confirmation">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

                                        <div class="form-group">
                                            <label class="form-label">Rol</label>
                                            <div class="controls">
                                                <select name="role_id" class="form-control">
                                                    @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                                        <option value="{{ $role->name }}"
                                                            @if ($data->hasRole($role->name) == $role->name) selected @endif>
                                                            {{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <br>

                                <h3>İcazələr</h3>
                                <div class="row">
                                    @foreach ($permissions as $key => $value)
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <input type="checkbox" @if ($data->can($value->name)) checked @endif
                                                    name="permissions[{{ $value->name }}]"
                                                    id="permission-{{ $key }}">
                                                <label for="permission-{{ $key }}">{{ $value->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <br>


                                <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                    <div class="text-left">
                                        <button type="submit" class="btn btn-primary">Təsdiq et</button>
                                        <a type="button" href="{{ route('admins.index') }}" class="btn">Ləğv
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