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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('expertise_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('date_start_treatment');
            $table->Text('address')->nullable();
            $table->string('clinic_phone')->unique()->nullable();
            $table->decimal('latitude', 10, 7)->nullable(); // اضافه کردن طول جغرافیایی
            $table->decimal('longitude', 10, 7)->nullable(); // اضافه کردن عرض جغرافیایی
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
