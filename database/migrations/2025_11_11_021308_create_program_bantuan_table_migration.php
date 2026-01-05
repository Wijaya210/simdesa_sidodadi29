<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('program_bantuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desa')->onDelete('cascade');
            $table->string('nama_program');
            $table->string('jenis_bantuan');
            $table->integer('jumlah_penerima')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_bantuan');
    }
};
