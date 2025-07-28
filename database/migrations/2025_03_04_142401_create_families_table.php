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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('national_id', 9)->unique();
            $table->string('name', 100);
            $table->date('birth_date');
            $table->text('health_status');
            $table->enum('academic_level', ['ابتدائي', 'إعدادي', 'ثانوي', 'دبلوم', 'بكالوريا', 'جامعي', 'دراسات عليا']);
            $table->string('profession', 100)->nullable();
            $table->tinyInteger('marriages_count')->default(1);
            $table->boolean('has_disabilities')->default(false);
            $table->boolean('disability_family')->default(false);
            $table->enum('family_type', ['ممتدة', 'نووية']);
            $table->boolean('has_health_insurance')->default(false);
            $table->string('health_insurance_reason')->nullable();
            $table->boolean('has_rehabilitation_centers')->default(false);
            $table->integer('healthy_adults_count')->default(1);
            $table->decimal('annual_income', 10, 2)->nullable();
            $table->enum('house_ownership', ['إيجار', 'ملك']);
            $table->integer('room_count')->default(1);
            $table->decimal('monthly_rent', 10, 2)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
