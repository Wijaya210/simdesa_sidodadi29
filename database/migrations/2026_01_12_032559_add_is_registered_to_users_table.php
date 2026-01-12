<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_registered')->default(false)->after('is_admin_added');
        });

        // Tandai warga yang sudah mendaftar sendiri sebagai is_registered = true
        // (Warga yang is_admin_added = false biasanya adalah yang daftar sendiri)
        DB::table('users')
            ->where('role', 'warga')
            ->where('is_admin_added', false)
            ->update(['is_registered' => true]);

        // Admin otomatis dianggap terdaftar
        DB::table('users')
            ->where('role', 'admin')
            ->update(['is_registered' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
