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
        Schema::create('mothers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained();
            $table->string('name', 100);
            $table->date('birth_date')->nullable();
            $table->string('health_status', 100);
            $table->enum('academic_level', ['ابتدائي', 'إعدادي', 'ثانوي', 'دبلوم', 'بكالوريا', 'جامعي', 'دراسات عليا']);
            $table->string('profession', 100)->nullable();
            $table->integer('marriages_count')->default(1);
            $table->char('national_id', 9)->unique();
            $table->string('relationship_with_father', 50);
            $table->boolean('has_disabilities')->nullable()->default(false);
            $table->boolean('had_diseases_during_pregnancy')->nullable()->default(false);
            $table->boolean('had_accidents_during_pregnancy')->nullable()->default(false);
            $table->boolean('smoked_during_pregnancy')->nullable()->default(false);
            $table->boolean('visited_doctor_during_pregnancy')->nullable()->default(false);
            $table->boolean('disability_family')->nullable()->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mothers');
    }
};
