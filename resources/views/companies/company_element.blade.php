<div class="company" id="company-{{ $data->id }}"
    onclick="window.open(`{{ route('companies.show', $data->additionalinfo->company_slugs[app()->getLocale() . '_slug'] ?? null) }}`)">
    <div class="info"
        onclick="window.open(`{{ route('companies.show', $data->additionalinfo->company_slugs[app()->getLocale() . '_slug'] ?? null) }}`)">
        <div class="image"
            onclick="window.open(`{{ route('companies.show', $data->additionalinfo->company_slugs[app()->getLocale() . '_slug'] ?? null) }}`)">
            <img data-src="@if (isset($data->additionalinfo->company_image) && !empty($data->additionalinfo->company_image)) {{ App\Helpers\Helper::getImageUrl($data->additionalinfo->company_image, 'users') }} @else {{ asset('assets/images/no-user.png') }} @endif"
                alt="{{ $data->additionalinfo->company_name[app()->getLocale() . '_name'] ?? null }}" class="lazyload blur-up" />
        </div>
        <div class="about"
            onclick="window.open(`{{ route('companies.show', $data->additionalinfo->company_slugs[app()->getLocale() . '_slug'] ?? null) }}`)">
            <h3 class="name"
                onclick="window.open(`{{ route('companies.show', $data->additionalinfo->company_slugs[app()->getLocale() . '_slug'] ?? null) }}`)">
                {{ $data->additionalinfo->company_name[app()->getLocale() . '_name'] ?? null }}</h3>
            <p class="descriptive"
                onclick="window.open(`{{ route('companies.show', $data->additionalinfo->company_slugs[app()->getLocale() . '_slug'] ?? null) }}`)">
                {{ mb_substr(App\Helpers\Helper::strip_tags_with_whitespace($data->additionalinfo->company_description[app()->getLocale() . '_description'] ?? null), 0, 250) }}
            </p>
        </div>
    </div>
    <div class="servicedatas"
        onclick="window.open(`{{ route('companies.show', $data->additionalinfo->company_slugs[app()->getLocale() . '_slug'] ?? null) }}`)">
        @lang('additional.pages.companies.services', ['services' => count($data->products)])
    </div>
</div>
