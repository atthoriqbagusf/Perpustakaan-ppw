@extends('layouts.master')

@section('content')


@if(count($data_buku))
    <div class="alert alert-success">
        Ditemukan <strong>{{ $jumlah_buku }}</strong>
        data dengan kata: <strong>{{ $cari }}</strong>
    </div>
@else
    <div class="alert alert-warning">
        <h4>Data "{{ $cari }}" tidak ditemukan</h4>
        <a href="{{ url('/buku') }}" class="btn btn-warning">
            Kembali
        </a>
    </div>
@endif



@if(Session::has('pesan'))
    <div class="alert alert-success">
        {{ Session::get('pesan') }}
    </div>
@endif

<h2>Data Buku</h2>

@if($data_buku->isEmpty())
<div class="alert alert-warning">
    Buku dengan judul "{{ request('judul') }}" tidak ditemukan.
</div>
@endif

<a href="{{ route('buku.create') }}" class="btn btn-primary float-end">Tambah Buku</a>

<form action="{{ route('buku.search') }}" method="get">@csrf
    <input type="text" name="kata" class="form-control" placeholder="Cari..." style="width: 30%; 
    display: inline; 
    margin-top: 10px; 
    margin-bottom: 10px; 
    float: right;">
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Harga</th>
            <th>Tanggal Terbit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data_buku as $index => $buku)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $buku->judul }}</td>
            <td>{{ $buku->penulis }}</td>
            <td>{{ number_format($buku->harga, 0, ',', '.') }}</td>
            <td>{{ $buku->tgl_terbit->format('d-m-Y') }}</td>
            <td>
                <form action="{{ route('buku.edit', $buku->id) }}" method="GET">
                    <button type="submit" class="btn btn-warning">Edit</button>
                </form>
                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin mau dihapus?')" type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div>{{ $data_buku->links('pagination::simple-bootstrap-5') }}</div>
<div><strong>Jumlah Buku: {{ $total_buku }}</strong></div>
<div class="row mt-4">
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

{{ $data_buku->links() }}

@endsection