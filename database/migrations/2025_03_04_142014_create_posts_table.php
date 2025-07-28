<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->enum('type', ['news', 'event', 'donation'])->default('news'); // نوع المنشور
            $table->text('post');              // محتوى المنشور (النص)
            $table->string('photo')->nullable(); // صورة مرفقة (اختياري)
            $table->string('video')->nullable(); // فيديو (رابط أو مرفوع)

            $table->unsignedBigInteger('user_id'); // معرف المستخدم الذي نشر
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->tinyInteger('active')->default(1); // منشور مفعل أو لا

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
}
