<section>
    <div class="container">
        <div class="row">
            <h2 class="text-center w-100">@if(!empty(lang_properties('categories','keyword'))) {{ lang_properties('categories','keyword')->name }} @else  @lang('additional.urls.categories') @endif</h2>
        </div>
        <div class="row category_items">
            <div class="column column-32 mobile_column-49 category-item all @if (!isset($selected_category) && empty($selected_category)) active @endif"
                onclick="searchinfields('all','datas','{{ $type }}','category')">
                <i class="lab la-buromobelexperte"></i>
                @lang('additional.pages.category.allcategories')
            </div>
            @foreach (categories() as $category)
                <div class="column column-32 mobile_column-49 category-item {{ $category->slugs[app()->getLocale() . '_slug'] }} @if (isset($selected_category) &&
                        !empty($selected_category) &&
                        $selected_category->slugs[app()->getLocale().'_slug'] == $category->slugs[app()->getLocale() . '_slug']
                ) active @endif"
                    onclick="searchinfields('{{ $category->slugs[app()->getLocale() . '_slug'] }}','datas','{{ $type }}','category')">
                    {!! $category->icon !!}
                    {{ $category->name[app()->getLocale() . '_name'] }}
                </div>
            @endforeach
        </div>
    </div>
</section>
