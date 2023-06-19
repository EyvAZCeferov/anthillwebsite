@if (count($data) > 0)
    @foreach ($data as $product)
        @include('services.service_element', ['data' => $product])
    @endforeach
@else
    <p class="text-center w-100 text-danger">@lang('additional.pages.category.datanotfound')</p>
@endif
