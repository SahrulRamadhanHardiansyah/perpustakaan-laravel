@extends('layouts.mainLayout')

@section('title', 'Pinjam Buku')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<div class="mb-4">
    <h2>Formulir Peminjaman Buku</h2>
</div>

<div class="card">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('message'))
            <div class="alert {{ session('alert-class') }}">
                {{ session('message') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{ route('proses.pinjam.buku') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="buku" class="form-label">Pilih Buku yang Ingin Dipinjam</label>
                        <select name="buku_id" id="buku" class="form-select select2" required>
                            <option value="">Pilih Buku</option>
                            @foreach ($buku as $item)
                                <option value="{{ $item->id }}">{{ $item->judul }}</option>
                            @endforeach
                        </select>
                        <div class="mb-3">
                            <label for="tgl_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo</label>
                            <input type="date" class="form-control" id="tgl_jatuh_tempo" name="tgl_jatuh_tempo" value="{{ old('tgl_jatuh_tempo') }}" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-journal-plus me-2"></i>Kirim Permintaan Pinjam</button>
                        <a href="/" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5'
        });
    });
</script>
@endsection