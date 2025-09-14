@extends('layouts.mainLayout')

@section('title', 'Pengembalian Buku')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<div class="mb-4">
    <h2>Form Pengembalian Buku</h2>
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
                <form action="{{ route('admin.proses.return.buku') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="peminjaman" class="form-label">Pilih Peminjaman</label>
                        <select name="peminjaman_id" id="peminjaman" class="form-select" required>
                            <option value="">Cari Siswa atau Judul Buku</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-journal-check me-2"></i>Kembalikan Buku</button>
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
        $('#peminjaman').select2({
            theme: 'bootstrap-5',
            ajax: {
                url: '{{ route("admin.peminjaman.search") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term 
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: 'Cari nama siswa atau judul buku...',
            minimumInputLength: 3,
        });
    });
</script>
@endsection