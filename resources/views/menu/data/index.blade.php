@extends('layout.main')
@section('content')
    {{-- Judul Halaman --}}
    <div class="page-header">
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
    <div class="card">
        <div class="card-header">
            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                <div class="col-md-4">
                    <div class="form-group">
                        <form action="{{ route('data.cari') }}" method="get">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search..." name="search"
                                    value="{{ isset($keyword) ? $keyword : '' }}">
                                <button class="btn" id="cari" type="submit">
                                    <i class="bi bi-search"></i>
                                    {{-- <button class="btn btn-primary"><i class="bi bi-search"></i></button> --}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-grid gap-1 d-md-flex justify-content-md-end">
                    <button type="button" class="btn" id="tombol-putih"
                        onClick="window.location.reload();">Refresh</button>
                    <a class="btn" id="tombol-putih" href="{{ route('data.tambah') }}">Tambah</a>
                    <a href="{{ route('data.view.import') }}" class="btn" id="tombol-putih">Import</a>
                </div>
            </div>
        </div>
        <div class="card-body">

            @if ($data->isNotEmpty())
                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Transaksi</th>
                                <th>Data</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        @foreach ($data as $dat => $dt)
                            <tr>
                                <td>{{ $data->firstItem() + $dat }}</td>
                                <td>{{ $dt->id_transaksi }}</td>
                                <td>{{ $dt->item }}</td>
                                <td>{{ $dt->tanggal }}</td>
                                <td>
                                    <div class="d-grid gap-1 d-md-flex">
                                        <a class="btn btn-sm" id="aksi-edit" href="/data/edit/{{ $dt->id_data }}">Edit</a>
                                        <form method="post" action="{{ route('data.destroy', $dt->id_data) }}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn text-light btn-sm" id="aksi-hapus"
                                                onclick="return confirm('Hapus data?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @else
                <p>Data transaksi kosong, harap tambah atau import data transaksi terlebih dahulu!</p>
            @endif


            {{-- Paginator --}}
            <div class="d-flex justify-content-end">
                {!! $data->links() !!}
            </div>
        </div>
    </div>
@endsection
