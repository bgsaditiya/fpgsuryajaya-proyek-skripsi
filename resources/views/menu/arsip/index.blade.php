@extends('layout.main')
@section('content')
    {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Welcome back, {{ auth()->user()->nama }}</h1>
    </div> --}}

    {{-- Judul Halaman --}}
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

    {{-- Main Content --}}
    <div class="card shadow-sm">
        <div class="card-header">

            {{-- Search bar and button --}}
            <div class="d-flex justify-content-between">
                <div class="col-md-4">
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
                <button type="button" id="tombol-putih" class="btn btn-primary" onClick="window.location.reload();">Refresh</button>
            </div>

        </div>
        <div class="card-body">

            {{-- Tabel Data --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Arsip</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @foreach ($arsip as $ars => $ar)
                        <tr>
                            <td>{{ $arsip->firstItem() + $ars }}</td>
                            <td>{{ $ar->username }}</td>
                            <td>{{ $ar->tgl_analisis }}</td>
                            <td>
                                <div class="d-grid gap-1 d-md-flex">
                                    <a class="btn btn-sm" id="aksi-edit" href="{{ route('arsip.show', $ar->id_arsip) }}">Lihat</a>
                                    <form method="post" action="{{ route('arsip.destroy', $ar->id_arsip) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" id="aksi-hapus" class="btn btn-sm"
                                            onclick="return confirm('Hapus arsip?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            {{-- Paginator --}}
            <div class="d-flex justify-content-end">
                {!! $arsip->links() !!}
            </div>
        </div>
    </div>
@endsection
