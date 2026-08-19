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
        Schema::create('sound_effects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['correct', 'wrong', 'complete']);
            $table->string('label');
            $table->string('audio_url');
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sound_effects');
    }
};
