@extends('layouts.mainLayout')

@section('title', 'Pencarian Barcode')

@section('content')
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-body-emphasis mb-8">Pencarian Buku via Barcode</h3>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body text-center">
                    <i class="bi bi-upc-scan" style="font-size: 5rem; color: #6c757d;"></i>
                    <h5 class="card-title mt-3">Pindai Barcode Buku</h5>
                    <p class="card-text">Gunakan alat pemindai Anda atau ketik manual kode barcode di bawah ini, lalu tekan Enter.</p>
                    
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.barcode.search.process') }}" method="POST">
                        @csrf
                        <div class="input-group input-group-lg">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="barcode" class="form-control" placeholder="Tunggu hasil pindaian..." autofocus>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection