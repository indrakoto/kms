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
        Schema::table('kms_articles', function (Blueprint $table) {
            $table->unsignedBigInteger('institusi_id')->nullable()->after('id'); // Tambahkan field institusi_id setelah field id, bisa null
            $table->foreign('institusi_id')->references('id')->on('kms_institusi')->onDelete('cascade'); // Definisikan sebagai foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kms_articles', function (Blueprint $table) {
            $table->dropForeign(['institusi_id']); // Hapus constraint foreign key
            $table->dropColumn('institusi_id');
        });
    }
};
