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
        Schema::create('skala_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori_jawaban')->constrained('kategori_jawaban')->onDelete('cascade');
            $table->string('nama_skala', 255)->required();
            $table->integer('nilai')->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skala_jawaban');
    }
};
