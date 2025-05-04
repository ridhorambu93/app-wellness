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
        Schema::table('surveys', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kategori_jawaban')->nullable();
            $table->foreign('id_kategori_jawaban')->references('id')->on('kategori_jawaban');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropForeign(['id_kategori_jawaban']);
            $table->dropColumn('id_kategori_jawaban');
        });
    }
};
