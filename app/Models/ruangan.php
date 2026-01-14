<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ruangan extends Model
{
    protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';

    protected $fillable = [
        'nama_ruangan',
        'lokasi'
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_ruangan');
    }
}
