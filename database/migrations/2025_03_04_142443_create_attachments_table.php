<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('tool_id')->constrained();
            $table->timestamp('assigned_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('received')->default (value: false)->nullable();
            $table->boolean('needed')->default (value: false)->nullable();
            $table->enum('source', ['مساهمة', 'اعفاء', 'مجانا'])->nullable();
            $table->decimal('price', 10)->default(0.00)->nullable();
            $table->decimal('exemption_value', 10)->nullable()->default(0.00)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
