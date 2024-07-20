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
        Schema::create('talk_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('theme');
            $table->string('link')->nullable();
            $table->dateTime('date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignUuid('event_id')->constrained('events')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talk_details');
    }
};
