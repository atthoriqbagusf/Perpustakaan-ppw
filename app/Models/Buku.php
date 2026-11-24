<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
class Buku extends Model
{
    protected $table = 'books';
    protected $fillable = ['judul', 'penulis', 'harga', 'tgl_terbit'];
    protected $casts = ['tgl_terbit' => 'date'];
    use HasFactory;

    public function images(): HasMany
    {
        return $this->hasMany(BukuImage::class);
    }

}


