@extends('layouts.mainLayout')

@section('title', 'Tambah Jenis')

@section('content')
    <h2>Tambah Jenis Baru</h2>

    <div class="mt-4 w-50">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="w-25">
        <form action="jenis-add" method="POST">
            @csrf
            <div class="">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" id="name" placeholder="Masukkan nama jenis" class="form-control">
            </div>
            <div class="mt-3">
                <button class="btn btn-success me-2" type="submit">Tambah</button>
                <a href="/jenis" class="btn btn-primary">Batal</a>
            </div>
        </form>
    </div>
@endsection