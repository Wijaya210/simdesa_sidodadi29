<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('statistik_desa', function (Blueprint $table) {
            $table->integer('jumlah_laki_laki')->default(0)->after('jumlah_penduduk');
            $table->integer('jumlah_perempuan')->default(0)->after('jumlah_laki_laki');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('statistik_desa', function (Blueprint $table) {
            $table->dropColumn(['jumlah_laki_laki', 'jumlah_perempuan']);
        });
    }
};
