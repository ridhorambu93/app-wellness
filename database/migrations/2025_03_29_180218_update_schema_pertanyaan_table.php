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
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->text('pertanyaan')->change();
            $table->foreign('id_kategori_jawaban')->references('id')->on('kategori_jawaban')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->string('pertanyaan', 255)->change();
            $table->dropForeign(['id_kategori_jawaban']);
        });
    }
};
