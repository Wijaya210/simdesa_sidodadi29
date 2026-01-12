<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desa';

    protected $fillable = [
        'nama_desa',
        'kepala_desa',
        'alamat',
        'kode_pos',
        'jumlah_penduduk',
    ];

    public function statistik()
    {
        return $this->hasOne(StatistikDesa::class, 'desa_id');
    }

    public function agama()
    {
        return $this->hasMany(AgamaDesa::class, 'desa_id');
    }

    public function pekerjaan()
    {
        return $this->hasMany(PekerjaanDesa::class, 'desa_id');
    }
}
