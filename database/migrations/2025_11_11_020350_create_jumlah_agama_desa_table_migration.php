<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jumlah_agama_desa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desa')->onDelete('cascade');
            $table->string('agama');
            $table->integer('jumlah')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jumlah_agama_desa');
    }
};
