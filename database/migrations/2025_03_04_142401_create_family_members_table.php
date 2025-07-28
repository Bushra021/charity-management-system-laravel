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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained();
            $table->string('name', 100);
            $table->year('birth_year');
            $table->enum('relationship', ['أخت', 'أخ', 'ابن', 'ابنة', 'زوجة', 'زوج']);
            $table->enum('social_status', ['أعزب', 'متزوج', 'مطلق', 'أرمل']);
            $table->enum('academic_level', [ 'ابتدائي', 'إعدادي', 'ثانوي', 'دبلوم', 'جامعي', 'دراسات عليا']);
            $table->text('health_status');
            $table->boolean('has_disability')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
