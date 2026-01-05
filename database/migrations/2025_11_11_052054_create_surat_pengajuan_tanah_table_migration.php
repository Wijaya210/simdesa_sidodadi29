<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_pengajuan_tanah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_pengajuan_id')
                ->constrained('surat_pengajuans')
                ->onDelete('cascade');
            $table->string('alamat_tanah');
            $table->decimal('luas_tanah', 10, 2);
            $table->string('status_kepemilikan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_pengajuan_tanah');
    }
};
