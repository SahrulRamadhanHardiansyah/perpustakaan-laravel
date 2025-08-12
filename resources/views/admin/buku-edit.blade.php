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
        <form action="/buku-edit/{{ $buku->slug }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mt-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" value="{{ $buku->judul }}" name="judul" id="judul" placeholder="Masukkan judul buku" class="form-control">
            </div>
            <div class="mt-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" name="gambar" id="gambar" class="form-control">
            </div>
            <div class="mt-3">
                <label for="currentImage" style="display: block" class="form-label">Gambar Saat Ini</label>
                @if ($buku->cover != null)
                    <img src="{{ asset('storage/cover/' . $buku->cover) }}" alt="" width="200">
                @else
                    <img src="{{ asset('images/cover-not-found.jpg') }}" alt="" width="200">
                @endif
            </div>
            <div class="mt-3">
                <label for="jenis" class="form-label">Jenis</label>
                <select name="jenis[]" id="jenis" class="form-select select-multiple" multiple>
                    @foreach ($jenis as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3">
                <label for="currentJenis" class="form-label">Jenis Saat ini</label>
                <ul>
                    @foreach ($buku->jenis as $item)
                        <li>{{ $item->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-3">
                <button class="btn btn-success me-2" type="submit">Edit</button>
                <a href="/buku" class="btn btn-primary">Batal</a>
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