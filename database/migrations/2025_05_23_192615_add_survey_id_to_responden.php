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
            if (!Schema::hasColumn('responden', 'survey_id')) {
                $table->bigInteger('survey_id')->nullable();
            }
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
