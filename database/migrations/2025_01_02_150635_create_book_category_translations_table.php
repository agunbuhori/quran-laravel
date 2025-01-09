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
        Schema::create('book_category_translations', function (Blueprint $table) {
            $table->engine('MyISAM');
            $table->increments('id');
            $table->unsignedSmallInteger('book_category_id');
            $table->char('lang', 2);
            $table->string('name', 100);

            $table->foreign('book_category_id')->references('id')->on('book_categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_category_translations');
    }
};
