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
            <a class="btn" id="tombol-putih" href="{{ route('data') }}">Kembali</a>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('data.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Pilih File</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="file" name="file" required>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn float-end" id="tombol" name="import">Import</button>
                </div>
            </form>
        </div>
    </div>
@endsection
