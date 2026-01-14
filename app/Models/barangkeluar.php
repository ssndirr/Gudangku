<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class barangkeluar extends Model
{
    protected $table = 'barang_keluar';
    protected $primaryKey = 'id_keluar';

    protected $fillable = [
        'id_barang',
        'tanggal_keluar',
        'jumlah'
    ];

    protected $dates = ['tanggal_keluar'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
