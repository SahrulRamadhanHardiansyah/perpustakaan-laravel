@extends('layouts.mainLayout')

@section('title', 'Daftar Siswa Diblokir')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Siswa Diblokir</h2>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-primary"><i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Siswa</a>
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
                    <th style="width: 30%;">Nama</th>
                    <th style="width: 25%;">Telepon</th>
                    <th class="text-center" style="width: 15%;">Status</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @forelse ($bannedSiswa as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->phone ?: '-' }}</td>
                        <td class="text-center">
                            <span class="badge text-bg-danger">{{ $item->status }}</span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.siswa.restore', ['slug' => $item->slug]) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" title="Restore">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Kembalikan
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada siswa yang diblokir.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection