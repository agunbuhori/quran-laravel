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
        Schema::create('ustadzs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('logo')->nullable();
            $table->string('front_degree', 10)->nullable();
            $table->string('back_degree', 10)->nullable();
            $table->integer('total_subscribers')->default(0);
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->text('biography')->nullable();
            $table->json('education')->nullable();
            $table->json('papers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ustadzs');
    }
};
