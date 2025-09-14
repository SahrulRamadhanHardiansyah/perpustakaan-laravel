@extends('layouts.mainLayout')

@section('title', 'Manajemen Denda')

@section('content')
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-body-emphasis mb-0">Manajemen Denda</h3>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Kembali</th>
                    <th>Jumlah Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dendaList as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->buku->judul }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_kembali)->isoFormat('D MMMM Y') }}</td>
                        <td>Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('admin.denda.bayar', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin denda ini sudah dibayar lunas?');">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-check-circle-fill"></i> Tandai Lunas
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada denda yang belum lunas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection