@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>{{trans('home.pagination.home')}}</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">{{trans('home.pagination.prev')}}</a></li>
        @endif
  
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span class="active">{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif  
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">{{trans('home.pagination.next')}}</a></li>
        @else
            <li class="disabled"><span>{{trans('home.pagination.last')}}</span></li>
        @endif
    </ul>
@endif
