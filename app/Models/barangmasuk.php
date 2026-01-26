<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barangmasuk';
    protected $primaryKey = 'id_masuk';

    protected $fillable = [
        'barang_id',
        'tanggal_masuk',
        'jumlah'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
