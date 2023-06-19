@extends("layouts.app")
@section('title')
    {{ $data->name[app()->getLocale()] }} -- {{ $data->code }}
@endsection
@section('addservice_menu', 'active')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
@endpush

@section("content")
@include('auth.left_profile_tab')
    <section>
        <div class="container">
            <div class="row profile_heaader">
                <h1 class="w-100 text-center">@lang('additional.urls.addservice')</h1>
            </div>
        </div>
        <div class="container">
            <div class="row margin-y-10">
                <form class="margin-y-40" onsubmit="formsend()" id="formsend">
                    <div id="messages" enctype="multipart/form-data"></div>
                    @csrf
                    <input type="hidden" name="token" value="{{$token}}" />
                    <input type="hidden" name="language" value="{{app()->getLocale()}}" />
                    <input type="hidden" name="user_id" value="{{auth()->user()->id}}" />
                    <div class="row add_service_row">
                        <div class="column column-30">
                            <p class="label_left">@lang('additional.forms.servicename')<span class="required">*</span> </p>
                        </div>
                        <div class="column column-70">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="@lang('additional.forms.servicename')">
                            </div>
                        </div>
                    </div>
                    <div class="row add_service_row">
                        <div class="column column-30">
                            <p class="label_left">@lang('additional.pages.auth.category')<span class="required">*</span> </p>
                        </div>
                        <div class="column column-70">
                            <div class="form-group">
                                <select name="category_id" class="form-control" onchange="change_category(event)">
                                    <option value="">@lang('additional.forms.selectcategory')</option>
                                    @foreach (categories() as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name[app()->getLocale() . '_name'] }}</option>
                                        @foreach ($category->alt_categoryes as $alt_cat)
                                            <option value="{{ $alt_cat->id }}">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $alt_cat->name[app()->getLocale() . '_name'] }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row add_service_row">
                        <div class="column column-30">
                            <p class="label_left">@lang('additional.forms.price')<span class="required">*</span></p>
                        </div>
                        <div class="column column-70">
                            <div class="form-group ">
                                <input type="text" class="form-control" name="price" placeholder="@lang('additional.forms.price')">
                                <span class="eye-icon">€</span>
                            </div>
                        </div>
                    </div>
                    <div id="attributes"></div>
                    <div class="row add_service_row">
                        <div class="column column-30">
                            <p class="label_left">@lang('additional.forms.additionalinfo')<span class="required">*</span></p>
                        </div>
                        <div class="column column-70">
                            <div class="form-group height-auto">
                                <textarea rows="10" name="additional_info" class="form-control" placeholder="@lang('additional.forms.enteradditionalinfo')"></textarea>
                            </div>
                        </div>
                    </div>
                </form>

                    <div class="row add_service_row">
                        <div class="column column-30">
                            <p class="label_left">@lang('additional.forms.images')<span class="required">*</span></p>
                        </div>
                        <div class="column column-70">
                            <div class="form-group height-auto addnewimage_area">
                                <form action="{{ route('api.imageuploadproduct', ['token' => $token]) }}" method="post">
                                    <div id="mydropzone" class="dropzone"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button class="submit" id="formsendbutton" form='formsend' type="submit">@lang('additional.buttons.add')</button>
                    </div>
            </div>
        </div>
    </section>
@endsection

