@extends('layouts.mainLayout')

@section('title', 'Tambah Buku')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-body-emphasis mb-0">Tambah Buku Baru</h3>
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
    
    <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" value="{{ old('judul') }}" name="judul" id="judul" placeholder="Masukkan judul buku" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" value="{{ old('author') }}" name="author" id="author" placeholder="Masukkan penulis buku" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Cover Buku</label>
                    <input type="file" name="gambar" id="gambar" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <select name="jenis_id" id="jenis" class="form-select" required>
                        <option value="">Pilih Jenis</option>
                        @foreach ($jenis as $item)
                            <option value="{{ $item->id }}" {{ old('jenis_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="kondisi" class="form-label">Kondisi</label>
                    <input type="text" value="{{ old('kondisi') }}" name="kondisi" id="kondisi" placeholder="Masukkan kondisi buku" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" value="{{ old('stok') }}" name="stok" id="stok" placeholder="Masukkan stok buku" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-success me-2" type="submit">Tambah</button>
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