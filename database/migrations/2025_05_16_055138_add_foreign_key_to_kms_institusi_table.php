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
        Schema::table('kms_institusi', function (Blueprint $table) {
            // Tambahkan index dan foreign key
            $table->index('parent');
            $table->foreign('parent')
                  ->references('id')
                  ->on('kms_institusi')
                  ->onDelete('SET NULL')
                  ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kms_institusi', function (Blueprint $table) {
            $table->dropForeign(['parent']);
            $table->dropIndex(['parent']);
        });
    }
};
