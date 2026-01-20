<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengajuanSktm extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function suratPengajuan()
    {
        return $this->belongsTo(SuratPengajuan::class);
    }
}
