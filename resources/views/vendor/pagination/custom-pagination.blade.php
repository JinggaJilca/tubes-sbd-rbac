@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-end"> {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link text-dark" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                </li>
            @endif

            {{-- Tombol Angka Halaman --}}
            @foreach ($elements as $element)
                
                {{-- "Three Dots" Separator (...) --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- LOGIKA TOMBOL AKTIF (KUNING) --}}
                            <li class="page-item active" aria-current="page">
                                <span class="page-link bg-primary border-primary text-dark fw-bold">{{ $page }}</span>
                            </li>
                        @else
                            {{-- LOGIKA TOMBOL BIASA (ABU-ABU) --}}
                            <li class="page-item">
                                <a class="page-link text-dark" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link text-dark" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif