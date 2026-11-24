<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Services\BukuImageService;
use Illuminate\Support\Arr;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $penulis_list = Buku::select('penulis')
            ->distinct()
            ->pluck('penulis');

        $query = Buku::with('images'); 

        if ($request->filled('penulis')) {
            $query->where('penulis', $request->penulis);
        }

        if ($request->filled('judul')) {
            $query->where('judul', 'like', '%' . $request->judul . '%');
        }

        $data_buku = $query->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        $total_buku  = Buku::count();
        $total_harga = Buku::sum('harga') ?? 0;
        $harga_max   = Buku::max('harga') ?? 0;
        $harga_min   = Buku::min('harga') ?? 0;

        return view('dashboard', compact(
            'data_buku',
            'penulis_list',
            'total_buku',
            'total_harga',
            'harga_max',
            'harga_min'
        ));
    }

    public function search(Request $request)
    {
        $batas = 5;
        $cari = $request->kata;

        $data_buku = Buku::with('images')
            ->where('judul', 'like', '%' . $cari . '%')
            ->orWhere('penulis', 'like', '%' . $cari . '%')
            ->orderByDesc('id')
            ->paginate($batas)
            ->withQueryString();

        $jumlah_buku = $data_buku->total();

        $no = $batas * ($data_buku->currentPage() - 1);

        return view('buku.search', compact(
            'jumlah_buku',
            'data_buku',
            'no',
            'cari'
        ));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request, BukuImageService $service)
    {
        $validated = $this->validate($request, [
            'judul'      => 'required|string',
            'penulis'    => 'required|string|max:30',
            'harga'      => 'required|numeric',
            'tgl_terbit' => 'required|date',
            'images'     => 'nullable|array|max:10',
            'images.*'   => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', 
        ], [
            'images.*.image' => 'Setiap file harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'images.*.max'   => 'Ukuran setiap gambar maksimal 2 MB.',
            'images.max'     => 'Maksimal 10 gambar sekali upload.',
        ]);

        $buku = Buku::create(Arr::except($validated, ['images']));

        if ($request->hasFile('images')) {
            $service->upload($buku, $request->file('images'));
        }

        return redirect('/buku')->with('pesan', 'Data Buku Berhasil Ditambahkan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $buku = Buku::with('images')->findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul'      => 'required|string',
            'penulis'    => 'required|string|max:30',
            'harga'      => 'required|numeric',
            'tgl_terbit' => 'required|date',
        ]);

        $buku = Buku::findOrFail($id);

        $buku->judul      = $request->judul;
        $buku->penulis    = $request->penulis;
        $buku->harga      = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();

        return redirect('/buku')->with('pesan', 'Data Buku Berhasil Disimpan');
    }

    public function destroy($id, BukuImageService $service)
    {
        $buku = Buku::findOrFail($id);

        $service->deleteAllFor($buku); 
        $buku->delete();

        return redirect('/buku')->with('pesan', 'Data Buku Berhasil Dihapus');
    }
}