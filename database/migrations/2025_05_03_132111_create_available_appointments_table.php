<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('available_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // الموظف المسؤول
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // الخدمة
            $table->date('date');       // يوم الموعد
            $table->time('start_time'); // بداية الجلسة
            $table->time('end_time');   // نهاية الجلسة
            $table->boolean('is_booked')->default(false); // هل تم حجزه أم لا
            $table->timestamps(); // created_at و updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('available_appointments');
    }
};
