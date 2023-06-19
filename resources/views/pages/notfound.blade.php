@extends('layouts.app')
@section('title')
    @lang('additional.pages.notfound.title')
@endsection

@section('content')
    <section>
        <div class="container">
            <div class="row profile_heaader">
                <h1 class="w-100 text-center">@lang('additional.pages.notfound.title')</h1>
            </div>
            <div class="row text-center">
                <a class="backtopage" href="{{ route('welcome') }}"><i class="las la-home"></i> @lang('additional.pages.notfound.returnhome')</a>
            </div>
        </div>
    </section>
    <br>
@endsection
