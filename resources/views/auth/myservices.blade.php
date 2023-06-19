@extends('layouts.app')
@section('title')
    @lang('additional.urls.myservices')
@endsection

@section('content')
    @include('auth.left_profile_tab')

    <section class="margin-y-10">
        <div class="w-75" style="margin:0 auto;">
            <div class="row">
                <h2 class="text-center w-100">@lang('additional.urls.myservices')</h2>
            </div>

            <div class="row services" id="datas">
                @if (count($data) > 0)
                    @foreach ($data as $product)
                        @include('services.service_element', ['data' => $product])
                    @endforeach
                @else
                    <p class="text-center w-100 text-danger">@lang('additional.pages.category.datanotfound')</p>
                @endif
            </div>
        </div>
    </section>
    <br />
@endsection
