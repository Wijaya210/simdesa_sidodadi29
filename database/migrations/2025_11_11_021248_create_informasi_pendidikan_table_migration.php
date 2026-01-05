<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('informasi_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desa')->onDelete('cascade');
            $table->string('tingkat_pendidikan');
            $table->integer('jumlah')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_pendidikan');
    }
};
