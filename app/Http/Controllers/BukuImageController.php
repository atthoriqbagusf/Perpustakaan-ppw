<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\BukuImage;
use App\Services\BukuImageService;
use Illuminate\Http\Request;

class BukuImageController extends Controller
{
    public function store(Request $request, Buku $buku, BukuImageService $service)
    {
        $request->validate([
            'images'   => 'required|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', 
        ], [
            'images.*.image' => 'Setiap file harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'images.*.max'   => 'Ukuran setiap gambar maksimal 2 MB.',
            'images.max'     => 'Maksimal 10 gambar sekali upload.',
        ]);

        $service->upload($buku, $request->file('images'));

        return back()->with('success', 'Gambar berhasil diupload.');
    }

    public function destroy(BukuImage $bukuImage, BukuImageService $service)
    {
        $service->delete($bukuImage);

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}