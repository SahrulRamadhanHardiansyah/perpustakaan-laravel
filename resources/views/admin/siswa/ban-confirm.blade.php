@extends('layouts.mainLayout')
@section('title', 'Ban Siswa')
@section('content')
    <h2>Konfirmasi Ban Siswa</h2>
    <h4 class="mt-3">Anda yakin ingin mem-banned siswa '{{$siswa->name}}' ?</h4>

    <div class="mt-4">
        <form action="{{ route('admin.siswa.destroy', ['slug' => $siswa->slug]) }}" method="post" class="d-inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger me-2">Ya, Ban Siswa</button>
        </form>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
    </div>
@endsection