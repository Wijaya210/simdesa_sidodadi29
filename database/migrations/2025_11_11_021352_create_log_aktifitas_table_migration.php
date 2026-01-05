<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_aktifitas', function (Blueprint $table) {
            $table->id();

            // Kolom admin_id sekarang nullable
            $table->unsignedBigInteger('admin_id')->nullable();

            // Foreign key ke users table
            $table->foreign('admin_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->string('aktivitas'); // contoh kolom
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_aktifitas');
    }
};
