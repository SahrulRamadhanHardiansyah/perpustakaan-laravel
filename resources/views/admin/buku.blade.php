@extends('layouts.mainLayout')

@section('title', 'Buku')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>List Buku</h2>
        <div>
            <a href="buku-add" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Buku</a>
            <a href="buku-deleted" class="btn btn-secondary"><i class="bi bi-eye me-2"></i>Lihat Data Dihapus</a>
        </div>
    </div>

    <div class="mt-4">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <div class="my-4 table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th class="text-center" style="width: 5%;">No.</th>
                    <th style="width: 30%;">Judul</th>
                    <th style="width: 20%;">Jenis</th>
                    <th class="text-center" style="width: 10%;">Status</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @if ($buku->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Tidak Ada Buku Ditemukan.</td>
                    </tr>
                @else
                    @foreach ($buku as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>
                                @forelse ($item->jenis as $jenis)
                                    <span class="badge text-bg-info me-1 mb-1">{{ $jenis->name }}</span>
                                @empty
                                    <span class="badge text-bg-secondary">Tidak Ada Jenis</span>
                                @endforelse
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $item->status == 'in stock' ? 'text-bg-success' : 'text-bg-warning' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="/buku-edit/{{ $item->slug }}" class="btn btn-primary btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    <a href="/buku-delete/{{ $item->slug }}" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

@endsection