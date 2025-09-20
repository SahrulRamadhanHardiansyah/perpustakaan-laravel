@extends('layouts.mainLayout')

@section('title', 'Peminjaman Buku')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<style>
    .selectable-card {
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }
    .selectable-card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .selectable-card.selected {
        border: 2px solid #0d6efd;
        box-shadow: 0 4px 20px rgba(13, 110, 253, 0.4);
    }
    #book-search-results {
        max-height: 500px;
        overflow-y: auto;
    }
</style>

<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <h3 class="text-body-emphasis mb-0">Form Pinjam Buku</h3>
</div>

@if ($errors->any() || session('message'))
<div class="row">
    <div class="col-md-7">
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
    </div>
</div>
@endif


<div class="row">
    <div class="col-md-5">
        <form action="{{ route('admin.rent.buku.store') }}" method="post" id="loan-form">
            @csrf
            <input type="hidden" name="buku_id" id="selected-book-id" required>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5>1. Detail Peminjaman</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="user" class="form-label">Pilih Siswa</label>
                        <select name="user_id" id="user" class="form-select" required>
                            <option value="">Cari nama siswa...</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_jatuh_tempo" class="form-label">Pilih Tanggal Jatuh Tempo</label>
                        <select name="tgl_jatuh_tempo" id="tgl_jatuh_tempo" class="form-select" required>
                            @for ($i = 1; $i <= 7; $i++)
                                @php $date = \Carbon\Carbon::now()->addDays($i); @endphp
                                <option value="{{ $date->toDateString() }}">
                                    {{ $date->isoFormat('dddd, D MMMM Y') }} ({{ $i }} hari)
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">Buku yang Dipilih</h6>
                </div>
                <div class="card-body">
                    <p id="selected-book-placeholder" class="text-muted">Pilih buku dari daftar di sebelah kanan.</p>
                    <h6 id="selected-book-title" class="d-none"></h6>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary w-100" type="submit" id="submit-loan-btn" disabled>
                    <i class="bi bi-journal-plus me-2"></i> Konfirmasi Peminjaman
                </button>
            </div>
        </form>
    </div>

    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-header">
                <h5>2. Cari dan Pilih Buku</h5>
            </div>
            <div class="card-body">
                <div class="row g-2 mb-3">
                    <div class="col-sm-8">
                        <input type="text" id="keyword-search" class="form-control" placeholder="Cari judul, author, atau scan barcode..." autofocus>
                    </div>
                    <div class="col-sm-4">
                        <select name="jenis" id="jenis-filter" class="form-select">
                            <option value="">Semua Jenis</option>
                            @foreach ($jenis as $item)
                                <option value="{{ $item->id }}" {{ request('jenis') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="book-search-results" class="row">
                </div>
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
                data: function(params) { return { term: params.term }; },
                processResults: function(data) { return { results: data }; },
                cache: true
            },
            placeholder: 'Cari nama siswa...',
        });

        $('#jenis-filter').select2({
            theme: 'bootstrap-5',
            placeholder: 'Filter berdasarkan jenis'
        });

        function loadBooks() {
            let keyword = $('#keyword-search').val();
            let jenis = $('#jenis-filter').val();

            $.ajax({
                url: '{{ route("buku.search.visual") }}',
                type: 'GET',
                data: {
                    keyword: keyword,
                    jenis: jenis
                },
                success: function(response) {
                    $('#book-search-results').html(response);
                }
            });
        }

        let searchTimeout;
        $('#keyword-search, #jenis-filter').on('input change', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(loadBooks, 300); 
        });

        $('#book-search-results').on('click', '.selectable-card', function() {
            $('.selectable-card').removeClass('selected');
            $(this).addClass('selected');

            let bookId = $(this).data('book-id');
            let bookTitle = $(this).data('book-title');

            $('#selected-book-id').val(bookId);
            $('#selected-book-title').text(bookTitle).removeClass('d-none');
            $('#selected-book-placeholder').addClass('d-none');

            $('#submit-loan-btn').prop('disabled', false);
        });

        loadBooks();
    });
</script>
@endsection