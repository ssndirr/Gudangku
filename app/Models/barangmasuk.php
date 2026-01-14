<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class barangmasuk extends Model
{
    protected $table = 'barang_masuk';
    protected $primaryKey = 'id_masuk';

    protected $fillable = [
        'id_barang',
        'tanggal_masuk',
        'jumlah'
    ];

    protected $dates = ['tanggal_masuk'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
