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
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kategori_jawaban')->nullable()->after('type');
            // Jika tabel kategori_jawaban sudah ada, Anda bisa menambahkan foreign key
            $table->foreign('id_kategori_jawaban')->references('id')->on('kategori_jawaban')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->dropForeign(['id_kategori_jawaban']);
            $table->dropColumn('id_kategori_jawaban');
        });
    }
};
