<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_pengajuan_usaha', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_pengajuan_id')
                ->constrained('surat_pengajuans')
                ->onDelete('cascade');
            $table->string('nama_usaha');
            $table->string('bidang_usaha');
            $table->string('alamat_usaha');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_pengajuan_usaha');
    }
};
