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
        Schema::create('kalimahs', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('ayah_id');
            $table->unsignedMediumInteger('position');
            $table->string('code_v1', 32);
            $table->string('code_v2', 32);
            $table->string('text_uthmani', 32);
            $table->string('qpc_uthmani_hafs', 32);
            $table->string('transliteration', 64)->nullable();

            $table->foreign('ayah_id')->references('id')->on('ayahs')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kalimahs');
    }
};
