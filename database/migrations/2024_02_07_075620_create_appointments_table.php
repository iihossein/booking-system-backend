<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('doctor_schedule_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('appointment_date_time');
            $table->enum('status', ['Scheduled', 'Expired', 'Reserved'])->default('Scheduled');
            $table->timestamps();
            // $table->unique(['doctor_id', 'appointment_date_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
