@extends('layout.main')
@section('content')
    <div class="page-header mb-4">
        <h1>{{ $title }}</h1>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Ganti Password</h5>
                    <p class="card-text">Mengganti password akun.</p>
                    <a href="{{ route('password') }}" class="btn" id="tombol">Ganti Password</a>
                </div>
                {{-- <div class="card-footer">
          <small class="text-body-secondary">Last updated 3 mins ago</small>
        </div> --}}
            </div>
        </div>

        @if (Auth::user()->jenis == 'admin')   
        <div class="col">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Kelola Akun Admin</h5>
                    <p class="card-text">Daftar seluruh akun Admin ada disini.</p>
                    <a href="{{ route('admin') }}" class="btn" id="tombol">Kelola Admin</a>
                </div>
                {{-- <div class="card-footer">
          <small class="text-body-secondary">Last updated 3 mins ago</small>
        </div> --}}
            </div>
        </div>

        <div class="col">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Kelola Akun Pegawai</h5>
                    <p class="card-text">Daftar seluruh akun Pegawai ada disini.</p>
                    <a href="{{ route('pegawai') }}" class="btn" id="tombol">Kelola Pegawai</a>
                </div>
                {{-- <div class="card-footer">
          <small class="text-body-secondary">Last updated 3 mins ago</small>
        </div> --}}
            </div>
        </div>
        @endif
        
    </div>
@endsection
