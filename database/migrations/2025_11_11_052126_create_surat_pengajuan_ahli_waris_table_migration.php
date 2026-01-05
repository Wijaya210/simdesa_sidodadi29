<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_pengajuan_ahli_waris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_pengajuan_id')
                ->constrained('surat_pengajuans')
                ->onDelete('cascade');
            $table->string('nama_ahli_waris');
            $table->string('hubungan');
            $table->string('nama_pewaris');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_pengajuan_ahli_waris');
    }
};
