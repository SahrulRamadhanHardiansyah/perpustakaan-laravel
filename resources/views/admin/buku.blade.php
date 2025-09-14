@extends('layouts.mainLayout')

@section('title', 'Buku')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>List Buku</h2>
        <div>
            <a href="{{ route('admin.buku.add') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Buku</a>
            <a href="{{ route('admin.buku.deleted') }}" class="btn btn-secondary"><i class="bi bi-eye me-2"></i>Lihat Data Dihapus</a>
        </div>
    </div>

    <div class="mt-4">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="card card-body mb-4 shadow-sm">
        <form action="" method="get">
            <div class="row g-2">
                <div class="col-12 col-sm-5">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari judul, author, atau scan barcode..." value="{{ request('keyword') }}">
                </div>
                <div class="col-12 col-sm-5">
                    <select name="jenis" id="jenis" class="form-select">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenis as $item)
                            <option value="{{ $item->id }}" {{ request('jenis') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="my-4 table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th class="text-center" style="width: 5%;">No.</th>
                    <th style="width: 30%;">Judul</th>
                    <th style="width: 20%;">Jenis</th>
                    <th style="width: 10%;">Stok</th>
                    <th style="width: 10%;">Kondisi</th>
                    <th>Barcode</th>
                    <th class="text-center" style="width: 10%;">Status</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @if ($buku->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">Tidak Ada Buku Ditemukan.</td>
                    </tr>
                @else
                    @foreach ($buku as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('admin.buku.show', $item->slug) }}" class="text-decoration-none text-black">
                                    {{ $item->judul }}
                                </a>
                            </td>
                            <td>
                                @if ($item->jenis)
                                    <span class="badge text-bg-info">{{ $item->jenis->name }}</span>
                                @else
                                    <span class="badge text-bg-secondary">Tidak Ada Jenis</span>
                                @endif
                            </td>
                            <td>{{ $item->stok }}</td>
                            <td>{{ $item->kondisi }}</td>
                            <td>
                                @if ($item->barcode)
                                    <div>{!! DNS1D::getBarcodeHTML($item->barcode, 'C128', 1.5, 33) !!}</div>
                                    <small>{{ $item->barcode }}</small>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $item->status == 'Tersedia' ? 'text-bg-success' : 'text-bg-danger' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.buku.edit', $item->slug) }}" class="btn btn-primary btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    <a href="{{ route('admin.buku.delete', $item->slug) }}" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#jenis').select2({
                theme: 'bootstrap-5',
                placeholder: 'Filter berdasarkan jenis'
            });
        });
    </script>

@endsection