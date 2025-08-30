@extends('layouts.mainLayout')

@section('title', 'Profile')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Profil Anda</h2>
        <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary d-flex align-items-center">
            <lord-icon
                src="https://cdn.lordicon.com/exymduqj.json"
                trigger="hover"
                stroke="bold"
                state="in-dynamic"
                colors="primary:#ffffff"
                class="me-2"
                style="width:25px;height:25px">
            </lord-icon>
            Edit Profile
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    
    <dl class="row mt-4">
        <dt class="col-sm-3 d-flex align-items-center mb-3">
            <lord-icon src="https://cdn.lordicon.com/bgebyztw.json" stroke="bold" trigger="hover" class="me-2" style="width:25px;height:25px"></lord-icon>
            Nama
        </dt>
        <dd class="col-sm-9 user-info mb-3">{{ $user->name }}</dd>

        <dt class="col-sm-3 d-flex align-items-center mb-3">
            <lord-icon src="https://cdn.lordicon.com/ebjjjrhp.json" stroke="bold" trigger="hover" class="me-2" style="width:25px;height:25px"></lord-icon>
            Email
        </dt>
        <dd class="col-sm-9 user-info mb-3">{{ $user->email }}</dd>

        <dt class="col-sm-3 d-flex align-items-center mb-3">
            <lord-icon src="https://cdn.lordicon.com/ssvybplt.json" stroke="bold" trigger="hover" class="me-2" style="width:25px;height:25px"></lord-icon>
            Telepon
        </dt>
        <dd class="col-sm-9 user-info mb-3">{{ $user->phone ?: '-' }}</dd>

        <dt class="col-sm-3 d-flex align-items-center mb-3">
            <lord-icon src="https://cdn.lordicon.com/onmwuuox.json" trigger="hover" stroke="bold" class="me-2" style="width:25px;height:25px"></lord-icon>
            Alamat
        </dt>
        <dd class="col-sm-9 user-info mb-3">{{ $user->address ?: '-' }}</dd>
    </dl>

    <script src="https://cdn.lordicon.com/lordicon.js"></script>
@endsection