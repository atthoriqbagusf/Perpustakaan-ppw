@extends('layouts.master')

@section('content')

@auth
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <h1 class="h3 mb-3">Dashboard</h1>

        <div class="alert alert-success">
            Selamat datang, {{ auth()->user()->name }}! Kamu berhasil login.
        </div>

        <h2 class="h5 mt-4">Informasi Pengguna</h2>
        <table class="table table-bordered mt-3 mb-0">
            <tbody>
                <tr>
                    <th style="width: 150px;">Nama</th>
                    <td>{{ auth()->user()->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ auth()->user()->email }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endauth

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center p-3">
            <h6 class="text-muted">Total Buku</h6>
            <h3>{{ $total_buku }}</h3>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center p-3">
            <h6 class="text-muted">Total Harga Semua Buku</h6>
            <h4>Rp {{ number_format($total_harga, 0, ',', '.') }}</h4>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center p-3">
            <h6 class="text-muted">Harga Tertinggi</h6>
            <h4>Rp {{ number_format($harga_max, 0, ',', '.') }}</h4>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center p-3">
            <h6 class="text-muted">Harga Terendah</h6>
            <h4>Rp {{ number_format($harga_min, 0, ',', '.') }}</h4>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Data Buku</h2>

            @auth
                <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
            @endauth
        </div>

        <form method="GET" action="{{ url()->current() }}" class="row g-2 mb-3">
            <div class="col-md-4">
                <select name="penulis" onchange="this.form.submit()" class="form-select">
                    <option value="">Semua Penulis</option>
                    @foreach($penulis_list as $p)
                        <option value="{{ $p }}" {{ request('penulis') == $p ? 'selected' : '' }}>
                            {{ $p }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-8 d-flex gap-2">
                <input type="text" name="judul" class="form-control"
                       placeholder="Cari judul buku..."
                       value="{{ request('judul') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        @if($data_buku->isEmpty())
            <div class="alert alert-warning">
                Buku dengan judul "{{ request('judul') }}" tidak ditemukan.
            </div>
        @endif

        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Harga</th>
                    <th>Tanggal Terbit</th>
                    @auth
                        <th>Aksi</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach($data_buku as $buku)
                <tr>
                    <td>{{ $data_buku->firstItem() + $loop->index }}</td>
                    <td>
                        @if($buku->images->isNotEmpty())
                            <div class="d-flex align-items-center gap-1">
                                <a href="{{ asset('storage/' . $buku->images->first()->image_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $buku->images->first()->thumbnail_path) }}"
                                        width="50" height="50" class="rounded object-fit-cover"
                                        alt="{{ $buku->judul }}">
                                </a>
                                @if($buku->images->count() > 1)
                                    <span class="badge text-bg-secondary">+{{ $buku->images->count() - 1 }}</span>
                                @endif
                            </div>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>{{ $buku->judul }}</td>
                    <td>{{ $buku->penulis }}</td>
                    <td>{{ number_format($buku->harga, 0, ',', '.') }}</td>
                    <td>{{ $buku->tgl_terbit->format('d-m-Y') }}</td>
                    @auth
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin mau dihapus?')" type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                    @endauth
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $data_buku->links('pagination::simple-bootstrap-5') }}

        <div class="mt-2"><strong>Jumlah Buku: {{ $total_buku }}</strong></div>
    </div>
</div>

@endsection