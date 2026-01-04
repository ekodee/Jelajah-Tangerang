<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <span class="align-middle">JELAJAHTANGERANG</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Wisata
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('kategori.index') }}">
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Kategori Wisata</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('destinasi.index') }}">
                    <i class="align-middle" data-feather="map-pin"></i> <span class="align-middle">Destinasi</span>
                </a>
            </li>

            <li class="sidebar-header">
                Artikel
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('artikel.index') }}">
                    <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Artikel</span>
                </a>
            </li>

            <li class="sidebar-header">
                Review
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('review.index') }}">
                    <i class="align-middle" data-feather="message-square"></i> <span class="align-middle">Reviews</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
