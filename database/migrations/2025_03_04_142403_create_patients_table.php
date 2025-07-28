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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mother_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unique('user_id');
            $table->foreignId('disability_type_id')->constrained();
            $table->foreignId('disability_cause_id')->constrained();
            $table->char('national_id', 9)->unique();
            $table->string('name', 100);
            $table->date('birth_date');
            $table->enum('social_status', ['أعزب', 'متزوج', 'مطلق', 'أرمل'])->default('أعزب');
            $table->date('injury_date');
            $table->enum('toilet_facilities', ['خارجي', 'داخلي'])->default('داخلي');
            $table->string('water_source');
            $table->string('electricity_source');
            $table->integer('family_order');
            $table->string('relationship_to_head', 50);
            $table->enum('disabled_person_residence',['داخل الأسرة','داخل مؤسسة','عند الأقارب']) ->default('داخل الأسرة');
            $table->string('education_reason')->nullable();
            $table->enum('education_type', ['مركز تربية خاصة', 'مدرسة عامة', 'جامعة'])->nullable();
            $table->char('unwra_card_number', 8)->nullable();
            $table->enum('employment_type', ['جزئي', 'كلي'])->nullable();
            $table->string('job_type')->nullable();
            $table->string('employment_method')->nullable();
            $table->boolean('vocational_training')->default(false);
            $table->boolean('social_case_responsible')->default(false);
            $table->boolean('disability_union_responsible')->default(false);
            $table->enum('employment_status', ['يعمل', 'لا يعمل'])->default('لا يعمل');
            $table->boolean('refugee_status')->default(false);
            $table->boolean('education_status')->default(false);
            $table->string('training_location')->nullable();
            $table->string('training_type')->nullable();
            $table->string('social_case_responsible_relation')->nullable();
            $table->decimal('permanent_disability_percentage', 5,2)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('fax_number', 20)->nullable();
            $table->string ('self_dependence_level');
            $table->decimal('monthly_income', 10,2);
            $table->boolean('profile_completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
