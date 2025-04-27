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
        Schema::table('kms_neraca', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name'); // Tambahkan field description setelah name, bisa null
            $table->unsignedBigInteger('institusi_id')->nullable()->after('description'); // Tambahkan field institusi_id setelah description, bisa null
            $table->foreign('institusi_id')->references('id')->on('kms_institusi')->onDelete('cascade'); // Foreign key ke kms_institusi

            $table->unsignedBigInteger('analisis_id')->nullable()->after('institusi_id'); // Tambahkan field analisis_id setelah institusi_id, bisa null
            $table->foreign('analisis_id')->references('id')->on('kms_analisis')->onDelete('cascade'); // Foreign key ke kms_analisis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kms_neraca', function (Blueprint $table) {
            $table->dropForeign(['analisis_id']);
            $table->dropColumn('analisis_id');

            $table->dropForeign(['institusi_id']);
            $table->dropColumn('institusi_id');

            $table->dropColumn('description');
        });
    }
};
