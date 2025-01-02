@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Tombol Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">«</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">«</a></li>
        @endif

        {{-- Jika Halamannya Sedikit --}}
        @if ($paginator->lastPage() <= 5)
            @foreach(range(1, $paginator->lastPage()) as $page)
                <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                </li>
            @endforeach
        @else
            {{-- Halaman Pertama --}}
            <li class="page-item {{ $paginator->currentPage() == 1 ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>

            {{-- Halaman 2, 3, 4 di Awal --}}
            @if ($paginator->currentPage() <= 3)
                @foreach(range(2, min(4, $paginator->lastPage() - 1)) as $page)
                    <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endforeach
                @if ($paginator->lastPage() > 5)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endif

            {{-- Titik Sebelum Halaman Tengah --}}
            @if ($paginator->currentPage() > 3 && $paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item disabled"><span class="page-link">...</span></li>
                @foreach(range($paginator->currentPage() - 1, $paginator->currentPage() + 1) as $page)
                    <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endforeach
                @if ($paginator->lastPage() > $paginator->currentPage() + 1)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endif

            {{-- Halaman 8, 9, 10, 11 di Akhir --}}
            @if ($paginator->currentPage() >= $paginator->lastPage() - 2)
                @if ($paginator->currentPage() > 3)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
                @foreach(range(max($paginator->lastPage() - 3, 2), $paginator->lastPage() - 1) as $page)
                    <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endforeach
            @endif

            {{-- Halaman Terakhir --}}
            @if ($paginator->lastPage() > 1)
                <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                </li>
            @endif
        @endif

        {{-- Tombol Berikutnya --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">»</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">»</span></li>
        @endif
    </ul>
@endif
