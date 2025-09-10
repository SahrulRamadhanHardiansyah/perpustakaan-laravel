@extends('layouts.mainLayout')

@section('title', 'Beranda')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if (Auth::user()->isGuru())
        <div class="alert alert-success shadow-sm mb-4">
            <h4 class="alert-heading">Selamat Datang, Guru {{ $user->name }}!</h4>
            <p>Anda dapat membantu siswa dalam proses peminjaman atau melihat daftar buku yang tersedia di bawah ini.</p>
            <hr>
            <a href="{{ route('guru.rent.buku') }}" class="btn btn-success">
                <i class="bi bi-bag-plus-fill"></i> Pinjamkan Buku
            </a>
            <a href="{{ route('guru.siswa.index') }}" class="btn btn-outline-success">
                <i class="bi bi-people-fill"></i> Lihat Daftar Siswa
            </a>
        </div>
    @elseif (Auth::user()->isSiswa())
        <div class="alert alert-info shadow-sm mb-4">
            <h4 class="alert-heading">Halo, Siswa {{ $user->name }}!</h4>
            @forelse ($pinjamanSiswa as $item)
                @if ($loop->first)
                    <p>Berikut adalah status peminjaman bukumu saat ini:</p>
                    <hr>
                    <ul class="mb-0">
                @endif
                        <li>
                            <strong>{{ $item->buku->judul }}</strong> (Jatuh tempo: {{ \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d F Y') }})
                        </li>
                @if ($loop->last)
                    </ul>
                @endif
            @empty
                <p class="mb-0">Kamu sedang tidak meminjam buku. Ayo cari buku menarik di bawah!</p>
            @endforelse
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>List Buku Tersedia</h2>
    </div>

    <div class="card card-body mb-4 shadow-sm">
        <form action="" method="get">
            <div class="row g-2">
                <div class="col-12 col-sm-5">
                    <input type="text" name="judul" class="form-control" placeholder="Cari berdasarkan judul..." value="{{ request('judul') }}">
                </div>
                <div class="col-12 col-sm-5">
                    <select name="jenis" id="jenis" class="form-select">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenis as $item)
                            <option value="{{ $item->id }}" {{ request('jenis') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="my-3">
        <div class="row">
            @forelse ($buku as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 book-card shadow-sm">
                        <div class="position-relative">
                            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('images/cover-not-found.png') }}" class="card-img-top" draggable="false" alt="{{ $item->slug }}">
                            
                            <span class="badge {{ $item->status == 'Tersedia' ? 'text-bg-success' : 'text-bg-danger' }} card-status-badge">
                                {{ $item->status }}
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ Str::limit($item->judul, 50, '...') }}</h5>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                @if ($item->jenis)
                                    <span class="badge text-bg-info me-1">{{ $item->jenis->name }}</span>
                                @else
                                    <span class="badge text-bg-secondary me-1">Tidak Ada Jenis</span>
                                @endif

                                <span class="badge {{ $item->stok > 0 ? 'text-bg-success' : 'text-bg-danger' }}">
                                    Stok: {{ $item->stok }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        <h4><i class="bi bi-exclamation-triangle"></i> Tidak Ada Buku Ditemukan</h4>
                        <p>Tidak ada buku yang cocok dengan kriteria pencarian Anda.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="my-4">
        <div class="d-flex justify-content-center">
            {{ $buku->withQueryString()->links() }}
        </div>
    </div>

@endsection