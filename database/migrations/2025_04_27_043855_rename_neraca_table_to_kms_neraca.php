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
        Schema::rename('neraca', 'kms_neraca');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('kms_neraca', 'neraca');
    }
};
