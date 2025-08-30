@extends('layouts.mainLayout')

@section('title', 'Edit Siswa')

@section('content')
    <h2>Edit Siswa</h2>

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
        <form action="{{ route('admin.siswa.update', $siswa->slug) }}" method="POST">
            @csrf
            @method('put')
            <div class="">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $siswa->name) }}" required>
            </div>
            <div class="mt-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $siswa->email) }}" readonly disabled>
            </div>
            <div class="mt-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone', $siswa->phone) }}" required>
            </div>
            <div class="mt-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control" id="address" name="address">{{ old('address', $siswa->address) }}</textarea>
            </div>
            <div class="mt-3">
                <label for="role" class="form-label">Peran</label>
                <select class="form-select" id="role_id" name="role_id" required>
                    <option value="2" {{ old('role_id', $siswa->role_id) == 2 ? 'selected' : '' }}>Siswa</option>
                    <option value="1" {{ old('role_id', $siswa->role_id) == 1 ? 'selected' : '' }}>Pustakawan</option>
                </select>
            </div>
            <div class="mt-3">
                <button class="btn btn-success me-2" type="submit">Edit</button>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-primary">Batal</a>
            </div>
        </form>
    </div>
@endsection