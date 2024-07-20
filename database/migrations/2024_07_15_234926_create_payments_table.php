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
        Schema::create('payment_banks',function (Blueprint $table){
            $table->id();
            $table->string('bank_name');
            $table->string('owner_name');
            $table->string('bank_number')->unique();
            $table->string('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('sender_name');
            $table->string('sender_bank');
            $table->foreignId('payment_bank_id')->constrained('payment_banks')->cascadeOnUpdate()->restrictOnDelete();
            $table->bigInteger('nominal');
            $table->string('payment_proof',255);
            $table->enum('validation_status',array_column(\App\Enums\ValidateStatusType::cases(),'value'))->nullable();
            $table->string('revision_messaage')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments_banks');
        Schema::dropIfExists('payments');
    }
};
