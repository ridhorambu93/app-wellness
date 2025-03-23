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
            $table->string('jenis_pertanyaan', 50)->change();
        });
    }

    public function down()
    {
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->enum('jenis_pertanyaan', ['pekerjaan', 'lingkungan_kerja', 'kepemimpinan', 'perusahaan'])->change();
        });
    }
};
