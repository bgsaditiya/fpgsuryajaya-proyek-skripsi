@extends('layout.main')
@section('content')
    <div class="d-flex">
        <h1 class="page-header">Selamat datang, {{ auth()->user()->nama }}</h1>
    </div>
@endsection