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
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->id();

            // ربط التقرير بالمريض
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');

            // عنوان التقرير (اختياري - يولد تلقائيًا)
            $table->string('title')->nullable();

            // محتوى التقرير كنص ثابت وقت الإنشاء
            $table->text('content')->nullable();

            // مسار ملف PDF إذا تم توليده أو رفعه
            $table->string('file_path')->nullable();

            // نوع التقرير: تلقائي أم يدوي
            $table->boolean('is_generated')->default(false);

            // تاريخ الإنشاء والتحديث
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_reports');
    }
};
