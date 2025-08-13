@extends('layouts.mainLayout')

@section('title', 'Edit Jenis')

@section('content')
    <h2>Edit Jenis</h2>

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
        <form action="{{ route('admin.jenis.update', $jenis->slug) }}" method="POST">
            @csrf
            @method('put')
            <div class="">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $jenis->name) }}" required>
            </div>
            <div class="mt-3">
                <button class="btn btn-success me-2" type="submit">Edit</button>
                <a href="{{ route('admin.jenis.index') }}" class="btn btn-primary">Batal</a>
            </div>
        </form>
    </div>
@endsection