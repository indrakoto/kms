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
            $table->dropForeign(['neraca_id']); // Hapus foreign key neraca_id jika ada
            $table->dropColumn('neraca_id');   // Hapus kolom neraca_id

            $table->dropForeign(['institusi_id']); // Hapus foreign key institusi_id jika ada
            $table->dropColumn('institusi_id'); // Hapus kolom institusi_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kms_analisis', function (Blueprint $table) {
            $table->unsignedBigInteger('neraca_id')->nullable()->after('id'); // Tambahkan kembali field neraca_id (untuk rollback)
            $table->foreign('neraca_id')->references('id')->on('kms_neraca')->onDelete('cascade'); // Tambahkan kembali foreign key neraca_id

            $table->unsignedBigInteger('institusi_id')->nullable()->after('neraca_id'); // Tambahkan kembali field institusi_id (untuk rollback)
            $table->foreign('institusi_id')->references('id')->on('kms_institusi')->onDelete('cascade'); // Tambahkan kembali foreign key institusi_id
        });
    }
};
