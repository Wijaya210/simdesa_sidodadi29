<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengajuan extends Model
{
    use HasFactory;

    protected $table = 'surat_pengajuans';

    protected $fillable = [
        'user_id',
        'jenis_surat',
        'status',
        'detail',
        'catatan_admin',
        'tanggal_pengajuan',
    ];

    protected $casts = [
        'detail' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
