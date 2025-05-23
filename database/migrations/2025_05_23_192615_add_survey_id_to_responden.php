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
        Schema::table('responden', function (Blueprint $table) {
            $table->bigInteger('survey_id')->nullable()->after('id_jawaban_responden');
            $table->index('survey_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responden', function (Blueprint $table) {
            //
        });
    }
};
