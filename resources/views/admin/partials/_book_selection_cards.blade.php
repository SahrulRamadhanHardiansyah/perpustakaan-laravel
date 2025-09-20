@forelse ($bukuList as $buku)
    <div class="col-md-4 col-sm-6 mb-4">
        <div class="card h-100 book-card selectable-card" data-book-id="{{ $buku->id }}" data-book-title="{{ $buku->judul }}">
            <img src="{{ $buku->gambar ? asset('storage/' . $buku->gambar) : asset('images/cover-not-found.png') }}" class="card-img-top" alt="{{ $buku->judul }}">
            <div class="card-body d-flex flex-column">
                <h6 class="card-title text-truncate">{{ $buku->judul }}</h6>
                
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <span class="badge text-bg-info">{{ $buku->jenis->name ?? 'N/A' }}</span>
                    
                    <span class="badge {{ $buku->stok > 0 ? 'text-bg-success' : 'text-bg-danger' }}">
                        Stok: {{ $buku->stok }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-warning text-center">
            Tidak ada buku yang cocok dengan pencarian Anda.
        </div>
    </div>
@endforelse