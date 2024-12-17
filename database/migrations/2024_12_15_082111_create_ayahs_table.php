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
        Schema::create('ayahs', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->smallIncrements('id');
            $table->unsignedTinyInteger('surah_id');
            $table->unsignedSmallInteger('ayah_number');
            $table->unsignedTinyInteger('hizb_number');
            $table->unsignedTinyInteger('rub_el_hizb_number');
            $table->unsignedSmallInteger('ruku_number');
            $table->unsignedTinyInteger('manzil_number');
            $table->unsignedTinyInteger('sajdah_number')->nullable();
            $table->unsignedSmallInteger('page_number');
            $table->unsignedTinyInteger('juz_number');
            $table->text('text_uthmani');
            $table->text('text_uthmani_simple');
            $table->text('text_uthmani_tajweed');
            $table->text('text_indopak');
            $table->text('text_imlaei');
            $table->text('text_imlaei_simple');

            $table->foreign('surah_id')->references('id')->on('surahs')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayahs');
    }
};
