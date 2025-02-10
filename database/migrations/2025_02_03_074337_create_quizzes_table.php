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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('tag');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('duration')->default(5);
            $table->unsignedTinyInteger('total_questions')->default(1);
            $table->enum('status', ['draft', 'published', 'unpublished'])->default('draft');
            $table->dateTime('closed_at')->nullable();
            $table->dateTime('announced_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
