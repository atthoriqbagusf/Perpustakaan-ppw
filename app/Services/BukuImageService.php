<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\BukuImage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;

class BukuImageService
{
    public function upload(Buku $buku, array $files): void
    {
        $manager = new ImageManager(new Driver());

        foreach ($files as $file) {
            $filename = now()->format('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.jpg';

            $original = $manager->decode($file)
                ->scaleDown(width: 1000)
                ->encode(new JpegEncoder(quality: 85));

            $thumbnail = $manager->decode($file)
                ->scaleDown(width: 300)
                ->encode(new JpegEncoder(quality: 70));

            $originalPath = 'buku_images/' . $filename;
            $thumbnailPath = 'buku_images_thumbnail/' . $filename;

            Storage::disk('public')->put($originalPath, (string) $original);
            Storage::disk('public')->put($thumbnailPath, (string) $thumbnail);

            $buku->images()->create([
                'image_path' => $originalPath,
                'thumbnail_path' => $thumbnailPath,
            ]);
        }
    }

    public function delete(BukuImage $image): void
    {
        Storage::disk('public')->delete(array_filter([
            $image->image_path,
            $image->thumbnail_path,
        ]));

        $image->delete();
    }

    public function deleteAllFor(Buku $buku): void
    {
        foreach ($buku->images as $image) {
            $this->delete($image);
        }
    }
}