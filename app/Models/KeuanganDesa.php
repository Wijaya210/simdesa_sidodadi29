<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeuanganDesa extends Model
{
    protected $fillable = [
        'tanggal',
        'keterangan',
        'jenis',
        'jumlah',
        'sumber',
    ];
}
