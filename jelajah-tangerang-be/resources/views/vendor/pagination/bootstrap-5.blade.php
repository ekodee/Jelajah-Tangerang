@if ($paginator->hasPages())
    <nav class="d-flex justify-content-end mt-3">
        <div class="btn-group">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="btn btn-outline-secondary disabled" aria-disabled="true">
                    <i class="align-middle" data-feather="chevron-left"></i>
                </span>
            @else
                <a class="btn btn-outline-secondary" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <i class="align-middle" data-feather="chevron-left"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="btn btn-outline-secondary disabled" aria-disabled="true">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="btn btn-primary" aria-current="page">{{ $page }}</span>
                        @else
                            <a class="btn btn-outline-secondary" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="btn btn-outline-secondary" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <i class="align-middle" data-feather="chevron-right"></i>
                </a>
            @else
                <span class="btn btn-outline-secondary disabled" aria-disabled="true">
                    <i class="align-middle" data-feather="chevron-right"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
