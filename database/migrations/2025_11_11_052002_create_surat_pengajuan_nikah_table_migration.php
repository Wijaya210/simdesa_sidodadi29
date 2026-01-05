<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_pengajuan_nikah', function (Blueprint $table) {
            $table->id();

            // FOREIGN KEY WAJIB
            $table->foreignId('surat_pengajuan_id')
                ->constrained('surat_pengajuans')
                ->onDelete('cascade');

            // kolom khusus surat nikah
            $table->string('nama_laki');
            $table->string('nama_perempuan');
            $table->date('tanggal_nikah');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_pengajuan_nikah');
    }
};
