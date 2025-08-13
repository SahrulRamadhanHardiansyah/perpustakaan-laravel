@extends('layouts.mainLayout')

@section('title', 'Detail Siswa')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ $siswa->name }}</h2>
        <div>
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Siswa</a>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success mt-4">
            {{ session('status') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Informasi Siswa</h5>
            <dl class="row">
                <dt class="col-sm-3">Nama</dt>
                <dd class="col-sm-9">{{ $siswa->name }}</dd>

                <dt class="col-sm-3">Telepon</dt>
                <dd class="col-sm-9">{{ $siswa->phone ?: '-' }}</dd>

                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9">{{ $siswa->address }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    <span class="badge {{ $siswa->status == 'Active' ? 'text-bg-success' : 'text-bg-danger' }}">
                        {{ $siswa->status }}
                    </span>
                </dd>
            </dl>
        </div>
    </div>

    <div class="my-4 table-responsive">
        <h4>Log Peminjaman {{ $siswa->name }}</h4>
        <x-log-peminjaman-table :logPeminjaman='$logPeminjaman'/>
    </div>

@endsection