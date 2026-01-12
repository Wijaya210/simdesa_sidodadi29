<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgamaDesa extends Model
{
    protected $table = 'jumlah_agama_desa';

    protected $fillable = [
        'desa_id',
        'agama',
        'jumlah',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}
