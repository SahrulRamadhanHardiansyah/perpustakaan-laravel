@extends('layouts.mainLayout')

@section('title', 'Edit Buku')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <h2>Edit Buku</h2>

    <div class="mt-4 w-50">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="w-25">
        <form action="{{ route('admin.buku.update', $buku->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mt-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" required>
            </div>
            <div class="mt-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" name="gambar" id="gambar" class="form-control">
            </div>
            <div class="mt-3">
                <label for="currentImage" style="display: block" class="form-label">Gambar Saat Ini</label>
                @if ($buku->gambar)
                    <img src="{{ asset('storage/' . $buku->gambar) }}" alt="Gambar Buku" width="200">
                @else
                    <p>Tidak ada gambar</p>
                @endif
            </div>
            <div class="mt-3">
                <label for="jenis" class="form-label">Jenis</slabel>
                <select name="jenis_id" id="jenis" class="form-control" required>
                    <option value="">Pilih Jenis</option>
                    @foreach ($jenis as $item)
                        <option value="{{ $item->id }}" {{ (old('jenis_id', $buku->jenis_id) == $item->id) ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3">
                <label for="currentJenis" class="form-label">Jenis Saat ini</label>
                <ul>
                    @if ($buku->jenis)
                        <span class="badge text-bg-info">{{ $buku->jenis->name }}</span>
                    @else
                        <span class="badge text-bg-secondary">Tidak Ada Jenis</span>
                    @endif
                </ul>
            </div>
            <div class="mt-3">
                <label for="kondisi" class="form-label">Kondisi</label>
                <input type="text" value="{{ old('kondisi', $buku->kondisi) }}" name="kondisi" id="kondisi" placeholder="Masukkan kondisi buku" class="form-control">
            </div>
            <div class="mt-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" value="{{ old('stok', $buku->stok) }}" name="stok" id="stok" placeholder="Masukkan stok buku" class="form-control">
            </div>

            <div class="mt-3">
                <button class="btn btn-success me-2" type="submit">Edit</button>
                <a href="{{ route('admin.buku.index') }}" class="btn btn-primary">Batal</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select-multiple').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
@endsection