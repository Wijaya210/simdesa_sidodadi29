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
        // 1. Nikah
        Schema::table('surat_pengajuan_nikah', function (Blueprint $table) {
            $table->dropColumn(['nama_laki', 'nama_perempuan', 'tanggal_nikah']);
            $table->string('nama_pasangan')->after('surat_pengajuan_id');
            $table->text('alamat_pasangan')->after('nama_pasangan');
        });

        // 2. Pindah
        Schema::table('surat_pengajuan_pindah', function (Blueprint $table) {
            $table->dropColumn(['alamat_asal', 'tanggal_pindah']);
            $table->string('provinsi_tujuan')->after('alamat_tujuan');
        });

        // 3. Tanah
        Schema::table('surat_pengajuan_tanah', function (Blueprint $table) {
            $table->dropColumn('status_kepemilikan');
            $table->renameColumn('alamat_tanah', 'lokasi_tanah');
        });

        // 4. Usaha
        Schema::table('surat_pengajuan_usaha', function (Blueprint $table) {
            $table->renameColumn('bidang_usaha', 'jenis_usaha');
        });

        // 5. Ahli Waris
        Schema::table('surat_pengajuan_ahli_waris', function (Blueprint $table) {
            $table->dropColumn(['nama_ahli_waris', 'nama_pewaris', 'hubungan']);
            $table->date('tgl_kematian')->after('surat_pengajuan_id');
            $table->string('hubungan_pewaris')->after('tgl_kematian');
        });
    }

    public function down(): void
    {
        // Revert 1. Nikah
        Schema::table('surat_pengajuan_nikah', function (Blueprint $table) {
            $table->dropColumn(['nama_pasangan', 'alamat_pasangan']);
            $table->string('nama_laki')->nullable();
            $table->string('nama_perempuan')->nullable();
            $table->date('tanggal_nikah')->nullable();
        });

        // Revert 2. Pindah
        Schema::table('surat_pengajuan_pindah', function (Blueprint $table) {
            $table->dropColumn('provinsi_tujuan');
            $table->string('alamat_asal')->nullable();
            $table->date('tanggal_pindah')->nullable();
        });

        // Revert 3. Tanah
        Schema::table('surat_pengajuan_tanah', function (Blueprint $table) {
            $table->string('status_kepemilikan')->nullable();
            $table->renameColumn('lokasi_tanah', 'alamat_tanah');
        });

        // Revert 4. Usaha
        Schema::table('surat_pengajuan_usaha', function (Blueprint $table) {
            $table->renameColumn('jenis_usaha', 'bidang_usaha');
        });

        // Revert 5. Ahli Waris
        Schema::table('surat_pengajuan_ahli_waris', function (Blueprint $table) {
            $table->dropColumn(['tgl_kematian', 'hubungan_pewaris']);
            $table->string('nama_ahli_waris')->nullable();
            $table->string('nama_pewaris')->nullable();
            $table->string('hubungan')->nullable();
        });
    }
};
