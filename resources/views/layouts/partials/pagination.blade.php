
@if ($paginator->hasPages())
    <div class="pagination-wrapper">
        <ul class="pg-pagination">
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li class="@if ($page == $currentpage??1) active @endif">
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>

    </div>
@endif
