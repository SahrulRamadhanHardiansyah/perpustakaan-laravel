@extends('layouts.mainLayout')

@section('title', 'List Buku')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>List Buku</h2>
    </div>

    <div class="card card-body mb-4">
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
                    <div class="card h-100 book-card">
                        <div class="position-relative">
                            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('images/cover-not-found.png') }}" class="card-img-top" draggable="false" alt="{{ $item->slug }}">
                            
                            <span class="badge {{ $item->status == 'Tersedia' ? 'text-bg-success' : 'text-bg-danger' }} card-status-badge">
                                {{ $item->status }}
                            </span>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ Str::limit($item->judul, 50, '...') }}</h5>
                            <div class="mb-3">
                                @if ($item->jenis)
                                    <span class="badge text-bg-info">{{ $item->jenis->name }}</span>
                                @else
                                    <span class="badge text-bg-secondary">Tidak Ada Jenis</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        <h4><i class="bi bi-exclamation-triangle"></i>Tidak Ada Buku Ditemukan</h4>
                        <p>Tidak ada buku yang cocok dengan kriteria pencarian Anda. Coba kata kunci atau filter yang berbeda.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="my-4">
        <div class="d-flex flex-column align-items-center">
            <div class="">
                {{ $buku->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection