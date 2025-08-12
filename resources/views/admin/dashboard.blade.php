@extends('layouts.mainLayout')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-4">
        <h2>Dashboard</h2>
        <p class="text-muted fs-5">Welcome, {{ Auth()->user()->username }}!</p>
    </div>

    <div class="row gy-4">
        <div class="col-lg-4">
            <div class="card-data card-books">
                <div class="card-icon">
                    <i class="bi bi-book"></i>
                </div>
                <div class="card-body">
                    <div class="card-count">{{ $hitungBuku }}</div>
                    <div class="card-desc">Buku</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-data card-categories">
                <div class="card-icon">
                    <i class="bi bi-tags"></i>
                </div>
                <div class="card-body">
                    <div class="card-count">{{ $hitungJenis }}</div>
                    <div class="card-desc">Jenis</div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card-data card-users">
                <div class="card-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="card-body">
                    <div class="card-count">{{ $hitungSiswa }}</div>
                    <div class="card-desc">Siswa</div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-4">
        <h3 class="mb-3">Log Peminjaman Terbaru</h3>
        <div class="table-responsive">
            <x-rent-logs-table :rentLogs='$rentLogs'/>
        </div>
    </div>
@endsection