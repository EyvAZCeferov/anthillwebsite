@extends('layouts.app')
@section('menu_media', 'open')
@section('title')
    {{ $data->name['az_name'] }} @lang('additional.urls.category') @lang('additional.page_types.update')
@endsection
@section('content')

@section('javascript')
    @include('layouts.seo.createseoscript')
@endsection

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper" style=''>

        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">

                <div class="pull-left">
                    <h1 class="title">{{ $data->name['az_name'] }} @lang('additional.urls.category') @lang('additional.page_types.update')
                        &nbsp;&nbsp;
                        <span>
                            @include('layouts.topbarbuttons', [
                                'routename' => 'category',
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
                            <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang('additional.urls.dashboard')</a>
                        </li>
                        <li>
                            <a href="{{ route('category.index') }}">@lang('additional.urls.category')</a>
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
                        <form action="{{ route('category.update', $data->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 mx-auto">


                                    <br>
                                    <input type="text"
                                        value="{{ isset($data->name['en_name']) ? $data->name['en_name'] : null }}"
                                        placeholder="@lang('additional.forms.name') ..." class="form-control" name="en_name">
                                    <br>
                                    @include('layouts.seo.createseo', [
                                        'langKey' => 'en',
                                        'data' => $data->seo ?? null,
                                    ])
                                    <br />
                                </div>

                            </div>
                            <br>
                            <div class="row">

                                <div class="col-sm-6 col-md-3">
                                    @if (!empty($data->image))
                                        <img width="200" src="{{ $data->image }}">
                                    @endif
                                    <div class="form-group">
                                        <label class="form-label">@lang('additional.forms.image')</label>
                                        <div class="controls">
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">@lang('additional.forms.icon')<br /> Icon library: <a
                                                target="_blank"
                                                href="https://icons8.com/line-awesome">https://icons8.com/line-awesome</a></label>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="icon"
                                                value="{{ isset($data) && !empty($data) && isset($data->icon) && !empty($data->icon) ? $data->icon : null }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="row">

                                <input type="hidden" value="3" name="type">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label"> @lang('additional.forms.status')</label>
                                        <div class="controls">
                                            <select name="status" required class="form-control">
                                                <option value="0"
                                                    @if ($data->status == false) selected @endif>@lang('additional.forms.statuses.passive')
                                                </option>
                                                <option value="1"
                                                    @if ($data->status == true) selected @endif>@lang('additional.forms.statuses.active')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label"> @lang('additional.forms.background_color')</label>
                                        <div class="controls">
                                            <input type="color" name="color" class="form-control"
                                                value="{{ !empty($data) && !empty($data->color) ? $data->color : '#67C347' }}">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <br>
                                <h4 class="px-3">@lang('additional.urls.attributes')</h4>
                                <br>
                                @foreach (attributes_for_admin()->whereNull('group_id') as $attribute)
                                    <div class="col-sm-4 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <label
                                                for="attribute-{{ $attribute->id }}">{{ $attribute->name['az_name'] }}</label>
                                            <input type="checkbox" name="attributesfor[]" class="form-control"
                                                value="{{ $attribute->id }}"
                                                @if ($data->attributes->where('attribute_group_id', $attribute->id)->first() != null) checked @endif
                                                id="attribute-{{ $attribute->id }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                            <br>


                            <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                <div class="text-left">
                                    <button type="submit" class="btn btn-primary">@lang('additional.buttons.submit')</button>
                                    <a type="button" href="{{ route('category.index') }}"
                                        class="btn">@lang('additional.buttons.cancel')</a>
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
