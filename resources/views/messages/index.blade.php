@extends('layouts.app')
@section('title')
    @lang('additional.urls.messages')
@endsection

@push('js')
    {{-- @vite(['resources/js/app.js']) --}}
    <script type="module" src="{{asset('build/assets/app-4fffdf2b.js')}}" ></script>
@endpush

@section('content')
    @include('auth.left_profile_tab')
    <div class="toast-container"></div>
    <section class="margin-y-10">
        <div class="w-75" style="margin:0 auto;">
            <div class="row">
                <h2 class="text-center w-100">@lang('additional.urls.messages')</h2>
            </div>
            <div class="row">
                <div id="app">
                    <messages-index></messages-index>
                </div>
            </div>
        </div>
    </section>
    <br>
@endsection
