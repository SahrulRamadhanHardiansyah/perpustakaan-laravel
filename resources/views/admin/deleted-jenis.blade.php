@extends('layouts.mainLayout')

@section('title', 'Jenis Dihapus')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>List Jenis Dihapus</h2>
        <a href="{{ route('admin.jenis.index') }}" class="btn btn-primary"><i class="bi bi-arrow-left me-2"></i>Kembali ke List Jenis</a>
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
                @forelse ($deletedJenis as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.jenis.restore', $item->slug) }}" class="btn btn-success btn-sm" title="Restore">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Kembalikan
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak Ada Jenis Dihapus Ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection