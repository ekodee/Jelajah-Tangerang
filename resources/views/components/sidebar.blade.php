<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">JELAJAHTANGERANG</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Wisata
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('kategori.index') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Kategori</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('destinasi.index') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Destinasi</span>
                </a>
            </li>
    </div>
</nav>
