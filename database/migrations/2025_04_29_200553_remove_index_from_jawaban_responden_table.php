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
        Schema::table('jawaban_responden', function (Blueprint $table) {
            $table->unsignedBigInteger('jawaban')->change();
        });
    }

    public function down(): void
    {
        Schema::table('jawaban_responden', function (Blueprint $table) {
            $table->string('jawaban')->change(); // Revert to the previous type
        });
    }
};
