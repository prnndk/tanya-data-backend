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
        Schema::create('coachings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('competition_name');
            $table->date('deadline_date');
            $table->string('idea');
            $table->string('progress');
            $table->string('request');
            $table->string('file');
            $table->foreignUuid('package_id')->constrained('package_data')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignUuid('registrant_id')->constrained('event_registrants')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coachings');
    }
};
