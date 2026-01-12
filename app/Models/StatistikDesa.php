<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistikDesa extends Model
{
    protected $table = 'statistik_desa';

    protected $fillable = [
        'desa_id',
        'jumlah_penduduk',
        'jumlah_laki_laki',
        'jumlah_perempuan',
        'jumlah_keluarga',
        'luas_wilayah',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}
