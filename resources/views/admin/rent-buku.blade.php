@extends('layouts.mainLayout')

@section('title', 'Peminjaman Buku')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<div class="mb-4">
    <h2>Form Pinjam Buku</h2>
</div>

<div class="card">
    <div class="card-body">
        @if (session('message'))
            <div class="alert {{ session('alert-class') }} alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{ route('admin.rent.buku.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="user" class="form-label">Siswa</label>
                        <select name="user_id" id="user" class="form-select" required>
                            <option value="">Pilih Siswa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="buku" class="form-label">Buku</label>
                        <select name="buku_id" id="buku" class="form-select" required>
                            <option value="">Pilih Buku</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo</label>
                        <select name="tgl_jatuh_tempo" id="tgl_jatuh_tempo" class="form-select" required>
                            <option value="" disabled selected>Pilih durasi peminjaman...</option>
                            @for ($i = 1; $i <= 7; $i++)
                                @php
                                    $date = \Carbon\Carbon::now()->addDays($i);
                                @endphp
                                <option value="{{ $date->toDateString() }}">
                                    {{ $date->isoFormat('dddd, D MMMM Y') }} ({{ $i }} hari)
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-journal-plus me-2"></i>Pinjam Buku</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Batal</a>
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
        $('#user').select2({
            theme: 'bootstrap-5',
            ajax: {
                url: '{{ route("admin.siswa.search") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { term: params.term };
                },
                processResults: function (data) {
                    return { results: data };
                },
                cache: true
            },
            placeholder: 'Cari nama siswa...',
            minimumInputLength: 3, 
        });

        $('#buku').select2({
            theme: 'bootstrap-5',
            ajax: {
                url: '{{ route("admin.buku.search") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { term: params.term };
                },
                processResults: function (data) {
                    return { results: data };
                },
                cache: true
            },
            placeholder: 'Cari judul buku atau scan barcode...',
            minimumInputLength: 3, 
        });

        $('#tgl_jatuh_tempo').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih tanggal jatuh tempo',
            minimumResultsForSearch: Infinity
        });
    });
</script>
@endsection