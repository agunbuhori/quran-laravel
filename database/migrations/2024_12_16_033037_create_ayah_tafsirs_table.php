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
        Schema::create('ayah_tafsirs', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->unsignedTinyInteger('tafsir_id');
            $table->unsignedSmallInteger('ayah_id');
            $table->longText('tafsir');
            $table->text('footnotes')->nullable();
            $table->timestamps();

            $table->foreign('tafsir_id')->references('id')->on('tafsir_books')->cascadeOnDelete();
            $table->foreign('ayah_id')->references('id')->on('ayahs')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayah_tafsirs');
    }
};
