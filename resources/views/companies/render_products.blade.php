@if (count($data) > 0)
    @foreach ($data as $dat)
        @include('companies.company_element', ['data' => $dat])
    @endforeach
@else
    <p class="text-center w-100 text-danger">@lang('additional.pages.category.datanotfound')</p>
@endif
