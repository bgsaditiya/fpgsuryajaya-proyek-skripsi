@extends('layout.main')
@section('content')
    <div class="page-header mb-4">
        <h1>{{ $title }}</h1>
    </div>

    @if ($errors->any())
        {{-- <div class="alert alert-danger d-flex align-items-center"> --}}
        <ul class="list-group mb-2">
            @foreach ($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">
                    <i class="bi bi-exclamation-circle-fill flex-shrink-0 me-2"> </i> {{ $error }}
                </li>
            @endforeach
        </ul>
        {{-- </div> --}}
    @endif

    <div class="card">
        <div class="card-header">
            <a class="btn" id="tombol-putih" href="{{ route('admin') }}">Kembali</a>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.store') }}">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Konfirmasi Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                </div>
                <button type="submit" id="tombol" class="btn float-end">Tambah</button>
            </form>
        </div>
    </div>
@endsection
