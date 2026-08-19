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
        Schema::create('soal_latihan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('materi_id')->constrained('materi')->cascadeOnDelete();
            $table->text('question');
            $table->json('options');
            $table->string('answer');
            $table->enum('type', ['multiple_choice', 'matching', 'audio', 'reading'])->default('multiple_choice');
            $table->string('audio_url')->nullable();
            $table->integer('level')->default(1);
            $table->integer('star')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_latihan');
    }
};
