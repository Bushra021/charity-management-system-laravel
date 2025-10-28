<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // تعديل username ليصبح اختياري (nullable)
            $table->string('username')->nullable()->change();

            // إضافة رقم الهوية اختياري + فريد
            $table->string('id_number')->nullable()->unique()->after('username');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // إعادة username لإجباري وفريد
            $table->string('username')->unique()->change();

            // حذف عمود رقم الهوية
            $table->dropColumn('id_number');
        });
    }
};
