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
        Schema::create('effects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->unique('patient_id');
            $table->foreignId('health_physical')->constrained('grades');
            $table->foreignId('health_mental')->constrained('grades');
            $table->foreignId('health_psychological')->constrained('grades');
            $table->foreignId('education')->constrained('grades');
            $table->foreignId('marital_life')->constrained('grades');
            $table->foreignId('social_activities')->constrained('grades');
            $table->foreignId('social_skills')->constrained('grades');
            $table->foreignId('self_management')->constrained('grades');
            $table->foreignId('family_relationship')->constrained('grades');
            $table->foreignId('work')->constrained('grades');
            $table->foreignId('financial_independence')->constrained('grades');
            $table->foreignId('public_life')->constrained('grades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('effects');
    }
};
