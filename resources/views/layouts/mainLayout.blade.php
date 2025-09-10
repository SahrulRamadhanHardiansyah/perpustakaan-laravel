<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Rental Buku</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{asset('css/layout.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <div class="main d-flex flex-column">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="#">
                    <i class="bi bi-book-half me-2"></i> Perpustakaan Laravel
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <div class="body-content flex-grow-1">
            <div class="row g-0 h-100">
                <div class="sidebar col-lg-2 collapse d-lg-block" id="sidebar">
                    @if (Auth::user())
                        @if (Auth::user()->isPustakawan()) {{-- Admin Pustakawan --}}
                            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-grid-fill"></i> Dashboard
                            </a>
                            <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">
                                <i class="bi bi-house-door-fill"></i> Beranda
                            </a>
                            <a href="{{ route('admin.buku.index') }}" class="{{ request()->routeIs('admin.buku*') ? 'active' : '' }}">
                                <i class="bi bi-book"></i> Buku
                            </a>
                            <a href="{{ route('admin.jenis.index') }}" class="{{ request()->routeIs('admin.jenis*') ? 'active' : '' }}">
                                <i class="bi bi-tags-fill"></i> Jenis
                            </a>
                            <a href="{{ route('admin.siswa.index') }}" class="{{ request()->routeIs('admin.siswa*') ? 'active' : '' }}">
                                <i class="bi bi-people-fill"></i> Siswa
                            </a>
                            <a href="{{ route('admin.rent.buku') }}" class="{{ request()->routeIs('admin.rent.buku') ? 'active' : '' }}">
                                <i class="bi bi-bag-plus-fill"></i> Pinjam Buku
                            </a>
                            <a href="{{ route('admin.return.buku') }}" class="{{ request()->routeIs('admin.return.buku') ? 'active' : '' }}">
                                <i class="bi-arrow-return-left"></i> Kembalikan Buku
                            </a>
                            <a href="{{ route('admin.peminjaman') }}" class="{{ request()->routeIs('admin.peminjaman') ? 'active' : '' }}">
                                <i class="bi bi-journals"></i> Log Peminjaman
                            </a>
                        @elseif (Auth::user()->isGuru()) {{-- Guru --}}
                            <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">
                                <i class="bi bi-house-door-fill"></i> Beranda
                            </a>
                            <a href="{{ route('guru.siswa.index') }}" class="{{ request()->routeIs('guru.siswa*') ? 'active' : '' }}">
                                <i class="bi bi-people-fill"></i> Siswa
                            </a>
                            <a href="{{ route('guru.rent.buku') }}" class="{{ request()->routeIs('guru.rent.buku') ? 'active' : '' }}">
                                <i class="bi bi-bag-plus-fill"></i> Pinjam Buku
                            </a>
                            <a href="{{ route('guru.return.buku') }}" class="{{ request()->routeIs('guru.return.buku') ? 'active' : '' }}">
                                <i class="bi-arrow-return-left"></i> Kembalikan Buku
                            </a>
                            <a href="{{ route('guru.peminjaman') }}" class="{{ request()->routeIs('guru.peminjaman') ? 'active' : '' }}">
                                <i class="bi bi-journals"></i> Log Peminjaman
                            </a>
                        @elseif (Auth::user()->isSiswa()) {{-- Siswa --}}
                            <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">
                                <i class="bi bi-house-door-fill"></i> Beranda
                            </a>
                            <a href="{{ route('pinjam.buku') }}" class="{{ request()->routeIs('pinjam.buku') ? 'active' : '' }}">
                                <i class="bi bi-bag-plus-fill"></i> Pinjam Buku
                            </a>
                        @endif
                        <a href="{{ Auth::user()->isSiswa() ? route('profile') : (Auth::user()->isGuru() ? route('guru.profile.index') : route('admin.profile.index')) }}"
                            class="{{ request()->routeIs('profile*') || request()->routeIs('admin.profile*') || request()->routeIs('guru.profile*') ? 'active' : '' }}">
                            <i class="bi bi-person-fill"></i> Profile
                        </a>
                        <hr class="text-white my-3"> {{-- Seperator --}}
                        <a href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    @endif
                </div>
                <div class="content-container p-4 col-lg-10">
                    <div class="content h-100 p-5">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>