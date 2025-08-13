@extends('layouts.mainLayout')

@section('title', 'Logs Peminjaman')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Log Peminjaman</h2>
    </div>

    <div class="mt-4">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <div class="my-4 table-responsive">
        <x-log-peminjaman-table :logPeminjaman='$logPeminjaman'/>
    </div>

@endsection