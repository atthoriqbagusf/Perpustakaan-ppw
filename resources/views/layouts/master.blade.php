<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/buku') }}">Perpustakaan</a>

            @auth
                <ul class="navbar-nav me-auto flex-row gap-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/buku') }}">Buku</a>
                    </li>

                    @if(Auth::user()->level == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/users') }}">Users</a>
                        </li>
                    @endif
                </ul>
            @endauth

            <div class="ms-auto d-flex align-items-center gap-2">
                @auth
                    <span class="text-white small">
                        {{ Auth::user()->name }}
                        <span class="badge bg-light text-primary">{{ Auth::user()->level }}</span>
                    </span>
                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-light">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container py-5">
        @if(Session::has('pesan'))
            <div class="alert alert-success">
                {{ Session::get('pesan') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        $('.date').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#btnTgl').on('click', function () {
            $('#tgl_terbit').datepicker('show');
        });
    </script>
</body>
</html>