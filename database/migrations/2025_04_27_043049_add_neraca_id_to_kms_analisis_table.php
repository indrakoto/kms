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
            $table->unsignedBigInteger('neraca_id')->nullable()->after('id'); // Ubah posisi menjadi setelah field id
            $table->foreign('neraca_id')->references('id')->on('neraca')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kms_analisis', function (Blueprint $table) {
            $table->dropForeign(['neraca_id']); // Hapus constraint foreign key
            $table->dropColumn('neraca_id'); // Hapus kolom neraca_id
        });
    }
};
