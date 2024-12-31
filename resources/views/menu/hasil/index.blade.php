@extends('layout.main')
@section('content')
    <div class="page-header mb-4">
        <h1>{{ $title }}</h1>
    </div>

    {{-- @foreach ($data as $row)
        {{ $tanggal[$row->id_transaksi] = $row->tanggal }}
    @endforeach --}}

    <div class="card mb-4">
        <div class="card-header">
            Konfigurasi
        </div>
        <div class="card-body">
        </div>
    </div>

@endsection
