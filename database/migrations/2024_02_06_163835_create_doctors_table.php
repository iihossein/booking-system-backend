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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('national_code');
            $table->foreignId('expertise_id')->constrained('expertises')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('code');
            $table->timestamp('date_start_treatment');
            $table->boolean('gender')->comment("[0] => man | [1] => women");
            $table->timestamp('birthday');
            $table->boolean('is_active')->default(1);
            $table->boolean('status')->default(1);
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
