<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PekerjaanDesa extends Model
{
    protected $table = 'statistik_pekerjaan';

    protected $fillable = [
        'desa_id',
        'pekerjaan',
        'jumlah',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}
