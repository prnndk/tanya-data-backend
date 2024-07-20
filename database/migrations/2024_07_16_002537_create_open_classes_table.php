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
        Schema::create('open_classes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('registrant_id')->constrained('event_registrants')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignUuid('package_id')->constrained('package_data')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open_classes');
    }
};
