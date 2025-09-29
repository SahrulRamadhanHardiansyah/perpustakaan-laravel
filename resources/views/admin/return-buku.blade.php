@extends('layouts.mainLayout')

@section('title', 'Pengembalian Buku')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <h3 class="text-body-emphasis mb-0">Form Pengembalian Buku</h3>
</div>

<div class="card shadow">
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
            <div class="alert {{ session('alert-class') }} alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{ Auth::user()->isPustakawan() ? route('admin.proses.return.buku') : route('guru.proses.return.buku') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="peminjaman" class="form-label">
                            {{ Auth::user()->isPustakawan() ? 'Cari Peminjaman' : 'Pilih Buku yang Akan Dikembalikan' }}
                        </label>
                        
                        @if (Auth::user()->isPustakawan())
                            <select name="peminjaman_id" id="peminjaman-search" class="form-select" required>
                                <option value="">Cari Siswa atau Judul Buku...</option>
                            </select>

                        @elseif (Auth::user()->isGuru())
                            <select name="peminjaman_id" id="peminjaman-list" class="form-select" required>
                                <option value="">Pilih buku...</option>
                                @foreach ($peminjaman as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->buku->judul }} (Jatuh Tempo: {{ \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->isoFormat('D MMM YYYY') }})
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-journal-check me-2"></i>Kembalikan Buku</button>
                        <a href="{{ Auth::user()->isPustakawan() ? route('admin.dashboard') : route('welcome') }}" class="btn btn-secondary">Batal</a>
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
        // Inisialisasi Select2 untuk pencarian AJAX (hanya untuk Admin)
        if ($('#peminjaman-search').length) {
            $('#peminjaman-search').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: '{{ route("admin.peminjaman.search") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return { term: params.term };
                    },
                    processResults: function(data) {
                        return { results: data };
                    },
                    cache: true
                },
                placeholder: 'Cari nama user atau judul buku...',
            });
        }

        // Inisialisasi Select2 untuk dropdown statis (hanya untuk Guru)
        if ($('#peminjaman-list').length) {
            $('#peminjaman-list').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih buku yang akan dikembalikan'
            });
        }
    });
</script>
@endsection