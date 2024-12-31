<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <title>Aplikasi | {{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/font-awesome/css/font-awesome.min.css">

    {{-- Style Saya --}}
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/main.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/fpg.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/all.min.css">

    {{-- Icon bootstarps --}}
    <link rel="stylesheet" href="{{ asset('/') }}assets/bootstrap/icon/font/bootstrap-icons.css">

</head>

<body data-coreui-spy="scroll" data-coreui-target="row" data-bs-offset="10">
    {{-- <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('partials.navbar')
            <div class="col py-3">
                @yield('content')
            </div>
        </div>
    </div> --}}

    <div class="dashboard">
        @include('partials.navbar')
        <div class="dashboard-app">
            <header class="dashboard-toolbar">
                <a class="menu-toggle">
                    <svg width="40" height="40" fill="none">
                        <path stroke="#373193" stroke-linecap="round" stroke-width="4"
                            d="M36.667 12.833H7.334M36.667 22H7.334M36.667 31.167H7.334" />
                    </svg>
                </a>
            </header>
            <div class="dashboard-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap js --}}
    <script src="{{ asset('/') }}assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    {{-- Main js --}}
    <script src="{{ asset('/') }}assets/js/jquery.min.js"></script>
    <script>
        const mobileScreen = window.matchMedia("(max-width: 990px )");
        $(document).ready(function() {
            $(".menu-toggle").click(function() {
                if (mobileScreen.matches) {
                    $(".dashboard-nav").toggleClass("mobile-show");
                } else {
                    $(".dashboard").toggleClass("dashboard-compact");
                    $(".dashboard-nav").toggleClass("dashboard-nav-close");
                }
            });
        });
    </script>
</body>

</html>
