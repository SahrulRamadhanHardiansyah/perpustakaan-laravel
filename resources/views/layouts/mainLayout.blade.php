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
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <i class="bi bi-book-half"></i> Rental Buku
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
                        @if (Auth::user()->role_id == 1) {{-- Admin Pustakawan --}}
                            <a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">
                                <i class="bi bi-grid-fill"></i> Dashboard
                            </a>
                            <a href="{{ url('/buku') }}" class="{{ Request::is('buku*') ? 'active' : '' }}">
                                <i class="bi bi-book"></i> Buku
                            </a>
                            <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">
                                <i class="bi bi-person-fill"></i> List Buku
                            </a>
                            <a href="{{ url('/jenis') }}" class="{{ Request::is('jenis*') ? 'active' : '' }}">
                                <i class="bi bi-tags-fill"></i> Jenis
                            </a>
                            <a href="{{ url('/siswa') }}" class="{{ Request::is('siswa*') ? 'active' : '' }}">
                                <i class="bi bi-people-fill"></i> Siswa
                            </a>
                            <a href="{{ url('/pinjam-buku') }}" class="{{ Request::is('pinjam-buku*') ? 'active' : '' }}">
                                <i class="bi bi-bag-plus-fill"></i> Pinjam Buku
                            </a>
                            <a href="{{ url('/kembalikan-buku') }}" class="{{ Request::is('kembalikan-buku*') ? 'active' : '' }}">
                                <i class="bi-arrow-return-left"></i> Kembalikan Buku
                            </a>
                            <a href="{{ url('/peminjaman') }}" class="{{ Request::is('peminjaman*') ? 'active' : '' }}">
                                <i class="bi bi-journals"></i> Log Peminjaman
                            </a>
                            <hr class="text-white my-3">
                            <a href="{{ url('/logout') }}">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        @elseif (Auth::user()->role_id == 2) {{-- Siswa --}}
                            <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">
                                <i class="bi bi-person-fill"></i> List Buku
                            </a>
                            <a href="{{ url('/pinjam-buku') }}" class="{{ Request::is('pinjam-buku*') ? 'active' : '' }}">
                                <i class="bi bi-bag-plus-fill"></i> Pinjam Buku
                            </a>
                            <a href="{{ url('/kembalikan-buku') }}" class="{{ Request::is('kembalikan-buku*') ? 'active' : '' }}">
                                <i class="bi-arrow-return-left"></i> Kembalikan Buku
                            </a>
                            <a href="{{ url('/profile') }}" class="{{ Request::is('profile*') ? 'active' : '' }}">
                                <i class="bi bi-person-fill"></i> Profile
                            </a>
                            <hr class="text-white my-3">
                            <a href="{{ url('/logout') }}">
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