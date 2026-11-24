@extends('layouts.master')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h2 class="h4 mb-4">Edit Buku</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form data buku (hanya field, tombol ada di bawah) --}}
        <form id="formUpdate" method="POST" action="{{ route('buku.update', $buku->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" id="judul" name="judul" class="form-control"
                       value="{{ old('judul', $buku->judul) }}" required>
            </div>

            <div class="mb-3">
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" id="penulis" name="penulis" class="form-control"
                       value="{{ old('penulis', $buku->penulis) }}" required>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" id="harga" name="harga" class="form-control"
                           value="{{ old('harga', $buku->harga) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="tgl_terbit" class="form-label">Tanggal Terbit</label>
                <div class="input-group">
                    <input type="text" id="tgl_terbit" name="tgl_terbit" class="date form-control"
                        placeholder="dd/mm/yyyy" autocomplete="off"
                        value="{{ old('tgl_terbit', $buku->tgl_terbit->format('d/m/Y')) }}" required>
                    <button type="button" class="btn btn-outline-secondary" id="btnTgl" aria-label="Pilih tanggal">
                        <i class="bi bi-calendar-event"></i>
                    </button>
                </div>
            </div>
        </form>

        <hr class="my-4">
        <h3 class="h5 mb-3">Gambar Buku</h3>

        {{-- Galeri gambar --}}
        <div class="row g-3 mb-4">
            @forelse($buku->images as $image)
                <div class="col-6 col-md-3">
                    <div class="card h-100">
                        <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank">
                            <img src="{{ asset('storage/' . $image->thumbnail_path) }}"
                                 class="card-img-top" alt="Gambar {{ $buku->judul }}">
                        </a>
                        <div class="card-body p-2">
                            <form action="{{ route('buku-images.destroy', $image->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus gambar ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-muted">Belum ada gambar.</div>
            @endforelse
        </div>

        {{-- Form upload gambar --}}
        <form action="{{ route('buku.images.store', $buku->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="mb-3">
                <label for="images" class="form-label">Tambah Gambar</label>
                @include('image.image-input')
            </div>
            <button type="submit" class="btn btn-success">Upload Gambar</button>
        </form>

        <hr class="my-4">

        <div class="d-flex gap-2">
            <button type="submit" form="formUpdate" class="btn btn-primary">Update</button>
            <a href="{{ url('/buku') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

@endsection