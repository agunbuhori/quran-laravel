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
        Schema::create('ayah_translations', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->mediumIncrements('id');
            $table->unsignedSmallInteger('ayah_id');
            $table->unsignedSmallInteger('translator_id');
            $table->text('translation');

            $table->foreign('ayah_id')->references('id')->on('ayahs')->cascadeOnDelete();
            $table->foreign('translator_id')->references('id')->on('translators')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayah_translations');
    }
};
