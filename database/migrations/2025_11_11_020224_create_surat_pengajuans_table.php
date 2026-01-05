<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_pengajuans', function (Blueprint $table) {
            $table->id();

            // 1. Foreign Key ke tabel users (Solusi untuk error 1005/150)
            $table->foreignId('user_id')
                ->constrained() // Secara otomatis merujuk ke tabel 'users' kolom 'id'
                ->onDelete('cascade'); // Jika user dihapus, pengajuan ikut terhapus

            // 2. Data Utama Pengajuan
            $table->string('jenis_surat');

            // 3. Kolom Tanggal Pengajuan (Penting, karena diisi di Controller)
            $table->timestamp('tanggal_pengajuan');

            // 4. Status dan Catatan Admin
            $table->string('status')->default('pending');
            $table->text('catatan_admin')->nullable();

            // 5. Detail Formulir Tambahan (Disimpan sebagai JSON)
            $table->json('detail')->nullable();

            // 6. Timestamps Laravel (created_at dan updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pengajuans');
    }
};
