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
        Schema::create('event_registrants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('event_id')->constrained('events')->restrictOnDelete()->cascadeOnUpdate();
            $table->enum('information_source',array_column(\App\Enums\InformationSourceType::cases(),'value'));
            $table->foreignUuid('payment_id')->constrained('payments')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('validation_status',array_column(\App\Enums\ValidateStatusType::cases(),'value'))->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_participants');
    }
};
