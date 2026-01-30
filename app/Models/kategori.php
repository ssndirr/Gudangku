<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
    ];

    /**
     * Get the barangs for the kategori.
     */
    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}