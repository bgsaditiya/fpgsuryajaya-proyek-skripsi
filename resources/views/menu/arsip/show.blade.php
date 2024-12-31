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

    <div class="card mb-4">
        <div class="card-header">
            Konfigurasi
        </div>
        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Jumlah Data</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $konfigurasi->jum_data }} Data" disabled
                            readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Jumlah Maksimal Rule</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $konfigurasi->max_rule }} Aturan" disabled
                            readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $user->username }}" disabled readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $user->nama }}" disabled readonly>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Rentang Tanggal</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                            value="{{ $konfigurasi->tgl_awal }} - {{ $konfigurasi->tgl_akhir }}" disabled readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Aturan Asosiasi
        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                <table class="table table-bordered table-hover table-striped datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Rule</th>
                            <th>Support</th>
                            <th>Confidence</th>
                            <th>Lift Ratio</th>
                        </tr>
                    </thead>
                    @php($no = 1)
                    @foreach ($asosiasi as $key => $val)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                Jika
                                <code>{{ implode(',', $val['left']) }}</code>
                                maka
                                <code>{{ implode(',', $val['right']) }}</code>
                            </td>
                            <td>{{ round($val['supp'] * 100, 2) }}%</td>
                            <td>{{ round($val['conf'] * 100, 2) }}%</td>
                            <td>{{ round($val['lift'], 2) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Rekomendasi
        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                <table class="table table-bordered table-hover table-striped datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Strong Rule</th>
                            <th colspan="2">Representasi Pengetahuan</th>
                            <th>Nilai Lift Ratio</th>
                        </tr>
                    </thead>
                    @php($no = 1)
                    @foreach ($asosiasi as $key => $val)
                        @if ($val['lift'] >= 1)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>
                                    Jika
                                    <code>{{ implode(', ', $val['left']) }}</code>
                                    maka
                                    <code>{{ implode(', ', $val['right']) }}</code>
                                </td>
                                <td>
                                    Item
                                    <code>{{ join(' dan ', array_filter(array_merge([join(', ', array_slice($val['merge'], 0, -1))], array_slice($val['merge'], -1)), 'strlen')) }}</code>
                                    harus ditempatkan pada rak yang berdekatan.
                                </td>
                                <td>
                                    Item
                                    <code>{{ join(' dan ', array_filter(array_merge([join(', ', array_slice($val['merge'], 0, -1))], array_slice($val['merge'], -1)), 'strlen')) }}</code>
                                    cocok untuk dijadikan paket pembelian.
                                </td>
                                <td>{{ round($val['lift'], 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
