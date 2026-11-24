@extends('layouts.master')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h2 class="h4 mb-4">Tambah Buku</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('buku.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" id="judul" name="judul" class="form-control"
                       value="{{ old('judul') }}" required>
            </div>

            <div class="mb-3">
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" id="penulis" name="penulis" class="form-control"
                       value="{{ old('penulis') }}" maxlength="30" required>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" id="harga" name="harga" class="form-control"
                           value="{{ old('harga') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="tgl_terbit" class="form-label">Tanggal Terbit</label>
                <div class="input-group">
                    <input type="text" id="tgl_terbit" name="tgl_terbit" class="date form-control"
                        placeholder="dd/mm/yyyy" autocomplete="off"
                        value="{{ old('tgl_terbit') }}" required>
                    <button type="button" class="btn btn-outline-secondary" id="btnTgl" aria-label="Pilih tanggal">
                        <i class="bi bi-calendar-event"></i>
                    </button>
                </div>
            </div>

            <hr class="my-4">
            <h3 class="h5 mb-3">Gambar Buku <span class="text-muted fw-normal fs-6">(opsional)</span></h3>

            <div class="mb-4">
                <label for="images" class="form-label">Pilih Gambar</label>
                @include('image.image-input')
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('/buku') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

@endsection