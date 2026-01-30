<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'ruangan_id',
        'stok',
    ];

    protected $casts = [
        'stok' => 'integer',
    ];

    /**
     * Get the kategori that owns the barang.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Get the ruangan that owns the barang.
     */
    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class);
    }

    /**
     * Get the barang masuks for the barang.
     */
    public function barangMasuks(): HasMany
    {
        return $this->hasMany(BarangMasuk::class);
    }

    /**
     * Get the barang keluars for the barang.
     */
    public function barangKeluars(): HasMany
    {
        return $this->hasMany(BarangKeluar::class);
    }

    /**
     * Update stock when barang masuk.
     */
    public function tambahStok(int $jumlah): void
    {
        $this->increment('stok', $jumlah);
    }

    /**
     * Update stock when barang keluar.
     */
    public function kurangiStok(int $jumlah): void
    {
        $this->decrement('stok', $jumlah);
    }

    /**
     * Check if stock is available.
     */
    public function isStokTersedia(int $jumlah): bool
    {
        return $this->stok >= $jumlah;
    }
}