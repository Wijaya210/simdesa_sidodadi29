<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postingan', function (Blueprint $table) {
            $table->id();

            // Foreign key ke users
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->string('judul');      // contoh kolom judul
            $table->text('konten');       // contoh kolom konten
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postingan');
    }
};
