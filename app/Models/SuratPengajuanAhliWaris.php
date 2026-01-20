<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengajuanAhliWaris extends Model
{
    use HasFactory;

    protected $table = 'surat_pengajuan_ahli_waris';
    protected $guarded = ['id'];

    public function pengajuan()
    {
        return $this->belongsTo(SuratPengajuan::class, 'surat_pengajuan_id');
    }
}
