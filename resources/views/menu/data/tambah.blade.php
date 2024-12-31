@extends('layout.main')
@section('content')
    <div class="page-header mb-4">
        <h1>{{ $title }}</h1>
    </div>
    <div class="card">
        <div class="card-header">
            <a class="btn" id="tombol-putih" href="{{ route('data') }}">Kembali</a>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('data.store') }}">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Id Transaksi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="id_transaksi" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Item</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="item" required>
                        <div class="form-text" id="basic-addon4">Pisahkan setiap item dengan koma.</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="tanggal" required>
                    </div>
                </div>
                <button type="submit" id="tombol" class="btn float-end">Tambah</button>
            </form>
        </div>
    </div>
@endsection
