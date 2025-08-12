@extends('layouts.mainLayout')

@section('title', 'Hapus Jenis')

@section('content')
    <h2>Hapus Jenis</h2>
    <h4>Apakah Anda yakin ingin menghapus jenis '{{$jenis->name}}'?</h4>

    <div class="mt-4">
        <a href="/jenis-destroy/{{$jenis->slug}}" class="btn btn-danger me-2">Hapus</a>
        <a href="/jenis" class="btn btn-primary">Batal</a>
    </div>
@endsection