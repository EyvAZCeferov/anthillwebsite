@extends('layouts.app')

@section('title')
    @if(!empty(standartpages('companies','type')))
        {{standartpages('companies','type')->seo->name[app()->getLocale().'_meta_title']}}
    @else
        @if(!empty(lang_properties('freelancers','keyword'))) {{ lang_properties('freelancers','keyword')->name }} @else  @lang("additional.urls.companies") @endif
    @endif
@endsection
@section('description')
    @if(!empty(standartpages('companies','type')))
        {{standartpages('companies','type')->seo->description[app()->getLocale().'_meta_description']}}
    @else
        @if(!empty(lang_properties('freelancers','keyword'))) {{ lang_properties('freelancers','keyword')->name }} @else  @lang("additional.urls.companies") @endif
    @endif
@endsection
@section('keywords')
    @if(!empty(standartpages('companies','type')))
        {{standartpages('companies','type')->seo->keywords[app()->getLocale().'_meta_keywords']}}
    @else
        @if(!empty(lang_properties('freelancers','keyword'))) {{ lang_properties('freelancers','keyword')->name }} @else  @lang("additional.urls.companies") @endif
    @endif
@endsection

@section('content')
    @include('services.search_filter',['type'=>'companies'])
    {{-- @include('services.categories',['type'=>'companies']) --}}
    <section>
        <div class="w-75 datasonshow" style="margin:0 auto;">
            <div class="row companies" id="datas">
                @if (count($data) > 0)
                    @foreach ($data as $dat)
                        @include('companies.company_element', ['data' => $dat])
                    @endforeach
                @else
                    <p class="text-center w-100 text-danger">@lang('additional.pages.category.datanotfound')</p>
                @endif
            </div>
        </div>
    </section>
@endsection
