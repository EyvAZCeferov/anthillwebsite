@extends('layouts.app')
@section('menu_media', 'open')
@section('title', $data->name['az_name'] . ' Kateqoriya Yenilə')
@section('content')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/flags/css/flag-icons.min.css') }}">
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->
    <link href="{{ asset('assets/plugins/tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css"
        media="screen" />
@endsection
@section('javascript')
@include('layouts.ckeditor.ckeditorService', [
        'uploadUrl' => route('ckEditorUpload'),
        'editors' => ['az_description', 'ru_description', 'en_description', 'tr_description'],
    ])
    @include('layouts.seo.createseoscript')
    <script src="{{ asset('assets/plugins/tagsinput/js/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
@endsection

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper" style=''>

        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">

                <div class="pull-left">
                    <h1 class="title">{{ $data->name['az_name'] }} Kateqoriya Yenilə
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
                            <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Ana səhifə</a>
                        </li>
                        <li>
                            <a href="{{ route('category.index') }}">Kateqoriya</a>
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

                                <ul class="nav nav-tabs nav-justified primary">
                                    <li class="active">
                                        <a href="#az" data-toggle="tab">
                                            <span class="flag-icon flag-icon-az"></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#ru" data-toggle="tab">
                                            <span class="flag-icon flag-icon-ru"></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#en" data-toggle="tab">
                                            <span class="flag-icon flag-icon-um"></span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="#tr" data-toggle="tab">
                                            <span class="flag-icon flag-icon-tr"></span>
                                        </a>
                                    </li> --}}
                                </ul>

                                <div class="tab-content primary">

                                    <div class="tab-pane fade in active" id="az">
                                        <br>
                                        <input type="text"
                                            value="{{ isset($data->name['az_name']) ? $data->name['az_name'] : null }}"
                                            placeholder="Adı daxil edin..." class="form-control" name="az_name">
                                        <br>

                                        @include('layouts.seo.createseo', [
                                            'langKey' => 'az',
                                            "data"=>$data->seo ?? null
                                        ])
                                        <br>

                                    </div>
                                    <div class="tab-pane fade" id="ru">
                                        <br>
                                        <input type="text"
                                            value="{{ isset($data->name['ru_name']) ? $data->name['ru_name'] : null }}"
                                            placeholder="Введите имя ..." class="form-control" name="ru_name">

                                        <br>
                                        @include('layouts.seo.createseo', [
                                            'langKey' => 'ru',
                                            "data"=>$data->seo ?? null
                                        ])
                                        <br/>

                                    </div>
                                    <div class="tab-pane fade" id="en">
                                        <br>
                                        <input type="text"
                                            value="{{ isset($data->name['en_name']) ? $data->name['en_name'] : null }}"
                                            placeholder="Enter the name ..." class="form-control" name="en_name">
                                        <br>
                                        @include('layouts.seo.createseo', [
                                            'langKey' => 'en',
                                            "data"=>$data->seo ?? null
                                        ])
                                        <br/>

                                    </div>

                                    {{-- <div class="tab-pane fade" id="tr">
                                        <br>
                                        <input type="text"
                                            value="{{ isset($data->name['tr_name']) ? $data->name['tr_name'] : null }}"
                                            placeholder="İsim giriniz ..." class="form-control" name="tr_name">
                                        <br>


                                    </div> --}}

                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label"> Üst Kateqoriya</label>
                                        <div class="controls">
                                            <select name="top_id" id="" class="form-control">
                                                <option value="">Bir kateqoriya seçin</option>

                                                @foreach (categories() as $category)
                                                    <option @if (isset($data->top_id) && $data->top_id != null && $data->top_id == $category->id) selected @endif
                                                        value="{{ $category->id }}">{{ $category->name['az_name'] }}
                                                    </option>
                                                    @foreach ($category->alt_categoryes as $sub)
                                                        <option value="{{ $sub->id }}"
                                                            @if (isset($data->top_id) && $data->top_id != null && $data->top_id == $sub->id) selected @endif>
                                                            &nbsp;&nbsp;-{{ $sub->name['az_name'] }}
                                                        </option>
                                                        @foreach ($sub->alt_categoryes as $subsub)
                                                            <option value="{{ $subsub->id }}"
                                                                @if (isset($data->top_id) && $data->top_id != null && $data->top_id == $subsub->id) selected @endif>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                --{{ $subsub->name['az_name'] }}
                                                            </option>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    @if (!empty($data->image))
                                        <img width="200" src="{{ $data->image }}">
                                    @endif
                                    <div class="form-group">
                                        <label class="form-label">Şəkil</label>
                                        <div class="controls">
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Ikon<br/> Icon library: <a target="_blank" href="https://icons8.com/line-awesome">https://icons8.com/line-awesome</a></label>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="icon" value="{{isset($data) && !empty($data) && isset($data->icon) && !empty($data->icon) ? $data->icon : null}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="row">

                                <input type="hidden" value="3" name="type">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label"> Status</label>
                                        <div class="controls">
                                            <select name="status" required class="form-control">
                                                <option value="0"
                                                    @if ($data->status == false) selected @endif>Passiv</option>
                                                <option value="1"
                                                    @if ($data->status == true) selected @endif>Aktiv</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label"> Kateqoriya Tipi</label>
                                        <div class="controls">
                                            <select name="category_type" class="form-control">
                                                <option value="1" @if($data->category_type==1) selected @endif >Yaşayış kompleksləri</option>
                                                <option value="2" @if($data->category_type==2) selected @endif >Ticarət obyektləri</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label"> Arxafon Rəng</label>
                                        <div class="controls">
                                            <input type="color" name="color" class="form-control"
                                                value="{{ !empty($data) && !empty($data->color) ? $data->color : '#67C347' }}">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <br>
                                <h4 class="px-3">Göstəriləcək Atributlar</h4>
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
                                    <button type="submit" class="btn btn-primary">Təsdiq et</button>
                                    <a type="button" href="{{ route('category.index') }}" class="btn">Ləğv
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
