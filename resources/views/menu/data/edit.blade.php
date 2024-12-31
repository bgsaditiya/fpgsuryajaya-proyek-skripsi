@extends('layout.main')
@section('content')
    <div class="page-header mb-4">
        <h1>{{ $title }}</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <a class="btn" id="tombol-putih" href="/data">Kembali</a>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('data.update', $iddata) }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Id Transaksi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="id_transaksi" value="{{ $idtransaksi }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Item</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="item" value="{{ $item }}" required>
                        <div class="form-text" id="basic-addon4">Pisahkan setiap item dengan koma.</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="tanggal" value="{{ $tanggal }}" required>
                    </div>
                </div>
                <button type="submit" class="btn float-end" id="tombol">Simpan</button>
            </form>
        </div>
    </div>
@endsection
