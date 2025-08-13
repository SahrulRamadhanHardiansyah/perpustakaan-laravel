@extends('layouts.mainLayout')

@section('title', 'Daftar Siswa')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Siswa</h2>
        <div>
            <a href="{{ route('admin.siswa.banned') }}" class="btn btn-warning"><i class="bi bi-eye me-2"></i>Lihat Siswa Diblokir</a>
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
                    <th style="width: 30%;">Nama</th>
                    <th style="width: 25%;">Telepon</th>
                    <th class="text-center" style="width: 10%;">Status</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @if ($siswa->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Siswa tidak ditemukan.</td>
                    </tr>
                @else
                    @foreach ($siswa as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone ?: '-' }}</td>
                            <td class="text-center">
                                <span class="badge text-bg-success">{{ $item->status }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.siswa.detail', ['slug' => $item->slug]) }}" class="btn btn-primary btn-sm" title="Detail"><i class="bi bi-person-lines-fill"></i></a>
                                    <a href="{{ route('admin.siswa.ban', ['slug' => $item->slug]) }}" class="btn btn-danger btn-sm" title="Ban User"><i class="bi bi-slash-circle"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

@endsection