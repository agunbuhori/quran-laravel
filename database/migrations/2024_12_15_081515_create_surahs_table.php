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
        Schema::create('surahs', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->tinyIncrements('id');
            $table->enum('revelation_place', ['makkah', 'madinah']);
            $table->unsignedTinyInteger('revelation_order');
            $table->boolean('bismillah_pre');
            $table->string('name_simple', 50);
            $table->string('name_complex', 50);
            $table->string('name_arabic', 50);
            $table->unsignedSmallInteger('ayahs_count');
            $table->json('pages');

            $table->foreign('id')->references('surah_id')->on('surah_translations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surahs');
    }
};
