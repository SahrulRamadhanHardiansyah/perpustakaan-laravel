@extends('layouts.mainLayout')

@section('title', 'Jenis')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>List Jenis</h2>
        <div>
            <a href="jenis-add" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Jenis</a>
            <a href="jenis-deleted" class="btn btn-secondary"><i class="bi bi-eye me-2"></i>Lihat Data Dihapus</a>
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
                    <th>Nama</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @if ($jenis->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center">Tidak Ada Jenis Ditemukan.</td>
                    </tr>
                @else
                    @foreach ($jenis as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td class="text-center">
                                <a href="jenis-edit/{{ $item->slug }}" class="btn btn-primary btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                <a href="jenis-delete/{{ $item->slug }}" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

@endsection