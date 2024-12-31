<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('/') }}assets/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('/') }}assets/css/main.css">

    <link rel="stylesheet" href="{{ asset('/') }}assets/bootstrap/icon/font/bootstrap-icons.css">

    <title>Aplikasi | Login</title>
</head>

<body>
    <div class="container">
        <div class="card position-absolute top-50 start-50 translate-middle" style="width: 30rem;">
            <div class="card-body">
                <h1 class="card-title mb-4 text-center">Login</h1>
                <form action="{{ route('auth') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" value="{{ old('username') }}" name="username" class="form-control"
                            required>
                        {{-- <input type="text" value="{{ old('username') }}" name="username"
                            class="form-control @error('username') is-invalid @enderror">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror --}}
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 d-grid">
                        <button name="submit" type="submit" class="btn text-light" id="login"
                            style="background-color: #373193;">Login</button>
                    </div>
                </form>
            </div>
            @if ($errors->any())
                <div class="card-footer">
                    <ul class="list-group mb-2">
                        @foreach ($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">
                                <i class="bi bi-exclamation-circle-fill flex-shrink-0 me-2"> </i> {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <script src="{{ asset('/') }}assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
