<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BukuImage extends Model
{
    protected $fillable = ['buku_id', 'image_path', 'thumbnail_path'];

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }
}