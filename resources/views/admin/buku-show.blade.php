@extends('layouts.mainLayout')

@section('title', 'Detail Buku')

@section('content')
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-body-emphasis mb-0">Detail Buku</h3>
        <a href="{{ route('welcome') }}" class="btn btn-secondary btn-md">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Buku
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ $buku->gambar ? asset('storage/' . $buku->gambar) : asset('images/cover-not-found.png') }}" 
                         class="img-fluid rounded mb-4" 
                         alt="Cover Buku" 
                         style="max-height: 400px; object-fit: cover;">

                    @if ($buku->barcode)
                        <div class="mt-3">
                            {!! DNS1D::getBarcodeHTML($buku->barcode, 'C128', 2, 50) !!}
                            <p class="mt-2"><strong>{{ $buku->barcode }}</strong></p>
                        </div>
                    @endif
                </div>

                <div class="col-md-8">
                    <h3>{{ $buku->judul }}</h3>
                    <p class="text-muted">oleh {{ $buku->author }}</p>
                    
                    <span class="badge {{ $buku->status == 'Tersedia' ? 'text-bg-success' : 'text-bg-danger' }}">
                        {{ $buku->status }}
                    </span>
                    <hr>
                    
                    <dl class="row">
                        <dt class="col-sm-3">Jenis</dt>
                        <dd class="col-sm-9">{{ $buku->jenis->name ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Stok</dt>
                        <dd class="col-sm-9">{{ $buku->stok }}</dd>

                        <dt class="col-sm-3">Kondisi</dt>
                        <dd class="col-sm-9">{{ $buku->kondisi }}</dd>
                        
                        <dt class="col-sm-3">Ditambahkan</dt>
                        <dd class="col-sm-9">{{ $buku->created_at->isoFormat('D MMMM YYYY') }}</dd>

                        <dt class="col-sm-3">Diperbarui</dt>
                        <dd class="col-sm-9">{{ $buku->updated_at->isoFormat('D MMMM YYYY') }}</dd>
                    </dl>

                    @if (Auth::user() && Auth::user()->isPustakawan())
                        <div class="mt-4">
                            <a href="{{ route('admin.buku.edit', $buku->slug) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="{{ route('admin.buku.delete', $buku->slug) }}" class="btn btn-danger">
                                <i class="bi bi-trash3-fill"></i> Hapus
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection