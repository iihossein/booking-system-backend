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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('payment_Amount',18,2);
            $table->timestamp('payment_date_time');
            $table->boolean('payment_status')->default(0)->comment("[0] => Awaiting Payment | [1] => Paid");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
