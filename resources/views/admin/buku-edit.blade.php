@extends('layouts.mainLayout')

@section('title', 'Edit Buku')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-body-emphasis mb-0">Edit Buku: {{ $buku->judul }}</h3>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.buku.update', $buku->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" required>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" value="{{ old('author', $buku->author) }}" name="author" id="author" placeholder="Masukkan penulis buku" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="kondisi" class="form-label">Kondisi</label>
                    <input type="text" value="{{ old('kondisi', $buku->kondisi) }}" name="kondisi" id="kondisi" placeholder="Masukkan kondisi buku" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" value="{{ old('stok', $buku->stok) }}" name="stok" id="stok" placeholder="Masukkan stok buku" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <select name="jenis_id" id="jenis" class="form-select" required>
                        <option value="">Pilih Jenis</option>
                        @foreach ($jenis as $item)
                            <option value="{{ $item->id }}" {{ (old('jenis_id', $buku->jenis_id) == $item->id) ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Ganti Cover Buku</label>
                    <input type="file" name="gambar" id="gambar" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="currentImage" class="form-label d-block">Cover Saat Ini</label>
                    @if ($buku->gambar)
                        <img class="rounded" src="{{ asset('storage/' . $buku->gambar) }}" alt="Cover Buku" width="150">
                    @else
                        <p class="text-muted">Tidak ada gambar</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label d-block">Barcode</label>
                    @if ($buku->barcode)
                        <div>{!! DNS1D::getBarcodeHTML($buku->barcode, 'C128', 1.5, 33) !!}</div>
                        <small class="text-muted">{{ $buku->barcode }}</small>
                        <button type="submit" name="generate_barcode" value="true" class="btn btn-sm btn-outline-secondary d-block mt-2">Buat Ulang Barcode</button>
                    @else
                        <p class="text-danger">Buku ini belum memiliki barcode.</p>
                        <button type="submit" name="generate_barcode" value="true" class="btn btn-primary">
                            <i class="bi bi-upc-scan me-2"></i> Buat Barcode Sekarang
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-success me-2" type="submit">Update</button>
            <a href="{{ route('admin.buku.index') }}" class="btn btn-primary">Batal</a>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#jenis').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Jenis Buku'
            });
        });
    </script>
@endsection