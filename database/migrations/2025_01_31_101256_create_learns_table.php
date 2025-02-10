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
        Schema::create('learns', function (Blueprint $table) {
            $table->engine = "MyISAM";
            $table->id();
            $table->string('title');
            $table->text('thumbnail')->nullable();
            $table->text('link')->nullable();
            $table->enum('type', ['ebook', 'youtube']);
            $table->string('tag');
            $table->string('youtube_id')->nullable();
            $table->foreignId('learn_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learns');
    }
};
