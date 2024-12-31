@extends('layout.main')
@section('content')
    <div class="page-header mb-4">
        <h1>{{ $title }}</h1>
    </div>

    {{-- Notif Updated Data --}}
    @if (session()->has('success'))
        <div class="alert alert-success d-flex align-items-center">
            <i class="bi bi-check-circle-fill flex-shrink-0 me-2"> </i>
            <div>
                {{ session()->get('success') }}
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">

            {{-- Search bar and button --}}
            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                <div class="d-grid gap-1 d-flex">
                    <a class="btn" id="tombol-putih" href="{{ route('pengaturan') }}">Kembali</a>

                    <div class="col">
                        <div class="form-group">
                            <form action="" method="get">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search..." name="search"
                                        value="{{ isset($keyword) ? $keyword : '' }}">
                                    <button class="btn" id="cari" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-1 d-md-flex justify-content-md-end">
                    <button type="button" id="tombol-putih" class="btn"
                        onClick="window.location.reload();">Refresh</button>
                    <a class="btn" id="tombol-putih" href="{{ route('pegawai.tambah') }}">Tambah</a>
                </div>
            </div>

        </div>
        <div class="card-body">

            {{-- Tabel Data --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @foreach ($pegawai as $adm => $ad)
                        <tr>
                            <td>{{ $pegawai->firstItem() + $adm }}</td>
                            <td>{{ $ad->username }}</td>
                            <td>{{ $ad->nama }}</td>
                            <td>
                                <div class="d-grid gap-1 d-md-flex">
                                    <a class="btn btn-sm" id="aksi-edit"
                                        href="{{ route('pegawai.edit', $ad->username) }}">Edit</a>
                                    <form method="post" action="{{ route('pegawai.destroy', $ad->username) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm" id="aksi-hapus"
                                            onclick="return confirm('Hapus akun?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            {{-- Paginator --}}
            <div class="d-flex justify-content-end">
                {!! $pegawai->links() !!}
            </div>
        </div>
    </div>
@endsection
