<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pilihan_jawaban', function (Blueprint $table) {
            $table->foreign('id_skala_jawaban')->references('id')->on('skala_jawaban')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pilihan_jawaban', function (Blueprint $table) {
            $table->dropForeign(['id_skala_jawaban']);
        });
    }
};
