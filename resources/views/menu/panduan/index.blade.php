@extends('layout.main')
@section('content')
    <div class="page-header mb-4">
        <h1>{{ $title }}</h1>
    </div>

    {{-- <a href="{{ route('view') }}">klik</a> --}}
    <div class="card">
        <div class="card-body">
            <div class="d-grid gap-4 d-flex">
                <div class="d-flex align-items-center">Panduan Aplikasi</div>
                <a href="{{ asset('/') }}assets/pdf/manualfpgsuryajaya.pdf" class="btn btn-primary" id="tombol">Download
                    PDF</a>
            </div>
        </div>
    </div>
    {{-- <iframe src="{{ asset('/') }}assets/pdf/akademik.pdf" width="50%" height="600">
        This browser does not support PDFs. Please download the PDF to view it:
        <a href="{{ asset('/') }}assets/pdf/akademik.pdf">Download PDF</a>
    </iframe> --}}

    {{-- <embed src="/pdf/akademik.pdf#page=2" type="application/pdf" width="100%" height="100%"> --}}
@endsection
