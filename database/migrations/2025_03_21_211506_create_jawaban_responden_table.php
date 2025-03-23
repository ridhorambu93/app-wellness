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
        Schema::create('jawaban_responden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_responden')->constrained('responden')->onDelete('cascade');
            $table->foreignId('id_pertanyaan')->constrained('pertanyaan')->onDelete('cascade');
            $table->foreignId('jawaban')->constrained('pilihan_jawaban')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_responden');
    }
};
