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
        Schema::create('soal_kuis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('language_id')->nullable()->constrained('languages')->nullOnDelete();
            $table->text('question');
            $table->json('options');
            $table->string('answer');
            $table->enum('difficulty', ['Mudah', 'Sedang', 'Sulit'])->default('Mudah');
            $table->string('type')->default('multiple_choice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_kuis');
    }
};
