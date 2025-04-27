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
        Schema::table('kms_analisis', function (Blueprint $table) {
            $table->dropForeign(['neraca_id']); // Hapus foreign key lama
            $table->foreign('neraca_id')
                  ->references('id')
                  ->on('kms_neraca') // Referensikan ke tabel kms_neraca
                  ->onDelete('cascade')
                  ->change(); // Tambahkan change() jika perlu mengubah struktur kolom
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analisis', function (Blueprint $table) {
            $table->dropForeign(['neraca_id']); // Hapus foreign key yang baru
            $table->foreign('neraca_id')
                  ->references('id')
                  ->on('neraca') // Kembalikan referensi ke tabel neraca (jika di-rollback sebelum rename)
                  ->onDelete('cascade')
                  ->change(); // Tambahkan change() jika perlu mengubah struktur kolom
        });
    }
};
