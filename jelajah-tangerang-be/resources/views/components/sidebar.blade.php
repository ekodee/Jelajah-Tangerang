<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <span class="align-middle">JELAJAHTANGERANG</span>
        </a>

        <ul class="sidebar-nav">

            {{-- 1. DASHBOARD (Semua User Login Bisa Lihat) --}}
            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            {{-- 2. MENU EDITOR & SUPER ADMIN (Kelola Konten) --}}
            {{-- Menggunakan Directive Spatie --}}
            @hasanyrole('super_admin|editor')
                <li class="sidebar-header">
                    Wisata & Konten
                </li>

                {{-- KATEGORI (Aktif jika route kategori.* sedang dibuka) --}}
                <li class="sidebar-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('kategori.index') }}">
                        <i class="align-middle" data-feather="list"></i> <span class="align-middle">Kategori Wisata</span>
                    </a>
                </li>

                {{-- DESTINASI --}}
                <li class="sidebar-item {{ request()->routeIs('destinasi.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('destinasi.index') }}">
                        <i class="align-middle" data-feather="map-pin"></i> <span class="align-middle">Destinasi</span>
                    </a>
                </li>

                {{-- ARTIKEL --}}
                <li class="sidebar-item {{ request()->routeIs('artikel.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('artikel.index') }}">
                        <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Artikel</span>
                    </a>
                </li>

                {{-- REVIEW --}}
                <li class="sidebar-item {{ request()->routeIs('review.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('review.index') }}">
                        <i class="align-middle" data-feather="message-square"></i> <span class="align-middle">Review</span>
                    </a>
                </li>
            @endhasanyrole

            {{-- 3. MENU KHUSUS SUPER ADMIN (Fitur Fatal) --}}
            @role('super_admin')
                <li class="sidebar-header">
                    Administrator
                </li>

                {{-- Contoh Menu Kelola User (Nanti dibuat) --}}
                <li class="sidebar-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="#">
                        <i class="align-middle" data-feather="users"></i> <span class="align-middle">Manajemen User</span>
                    </a>
                </li>
            @endrole

        </ul>
    </div>
</nav>
