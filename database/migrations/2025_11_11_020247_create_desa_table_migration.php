<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa');
            $table->string('kepala_desa');
            $table->string('alamat');
            $table->string('kode_pos', 10)->nullable();
            $table->integer('jumlah_penduduk')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desa');
    }
};
