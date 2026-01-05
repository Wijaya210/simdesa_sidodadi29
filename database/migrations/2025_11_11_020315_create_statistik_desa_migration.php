<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('statistik_desa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desa')->onDelete('cascade');
            $table->integer('jumlah_penduduk')->default(0);
            $table->integer('jumlah_keluarga')->default(0);
            $table->float('luas_wilayah')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistik_desa');
    }
};
