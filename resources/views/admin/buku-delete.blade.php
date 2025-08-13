@extends('layouts.mainLayout')

@section('title', 'Hapus Buku')

@section('content')
    <h2>Hapus Buku</h2>
    <h4>Apakah Anda yakin ingin menghapus buku '{{$buku->judul}}'?</h4>

    <div class="mt-4">
        <a href="{{ route('admin.buku.destroy', $buku->slug) }}" class="btn btn-danger me-2">Hapus</a>
        <a href="{{ route('admin.buku.index') }}" class="btn btn-primary">Batal</a>
    </div>
@endsection