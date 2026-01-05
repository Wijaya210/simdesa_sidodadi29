<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('postingan', function (Blueprint $table) {
            // contoh relasi tambahan
            // $table->foreignId('desa_id')->nullable()->constrained('desa')->onDelete('set null');
        });

        Schema::table('log_aktifitas', function (Blueprint $table) {
            // relasi tambahan juga bisa ditulis di sini kalau dibutuhkan
        });
    }

    public function down(): void
    {
        Schema::table('postingan', function (Blueprint $table) {
            // rollback relasi tambahan
            // $table->dropForeign(['desa_id']);
        });
    }
};
