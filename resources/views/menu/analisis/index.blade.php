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

    <div class="card mb-4">
        <div class="card-body">
            <form method="post" action="{{ route('fpgrowth') }}">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Tanggal Awal</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="tanggal_awal" value="{{ $tanggal_awal }}" required
                            @error('tanggal_awal') is-invalid @enderror>
                        @error('tanggal_awal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Tanggal Akhir</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="tanggal_akhir" value="{{ $tanggal_akhir }}"
                            required @error('tanggal_akhir') is-invalid @enderror>
                        @error('tanggal_akhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Jumlah Maksimal Aturan</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="max_rule" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Tampilan FP-Growth</label>
                    <div class="col-sm-10">
                        {{-- <input type="number" class="form-control" name="max_rule" required> --}}
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tampilan" value="sederhana"
                                id="flexRadioDefault1" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Tampilan Sederhana
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tampilan" value="lengkap"
                                id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Tampilan Lengkap
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn float-end" id="tombol"> Hitung</button>
            </form>
        </div>
    </div>

    {{-- <div class="card border-success mb-4">
        <div class="card-body text-success">
            <h5 class="card-title">Petunjuk</h5>
            <p class="card-text">Nilai minimum support adalah bla bla bla</p>
            <p class="card-text">Nilai minimum confidence adalah bla bla bla</p>
        </div>
    </div> --}}
@endsection
