<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';

    protected $primaryKey = 'id_ruangan';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_ruangan',
        'lokasi',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'ruangan_id');
    }
}
