<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('usergmail', 50); // Sử dụng string để tham chiếu đến usergmail
            $table->string('name');         // tên chủ đề
            $table->string('slug');         // slug duy nhất theo user
            $table->timestamps();

            // Tạo foreign key constraint
            $table->foreign('user_id')->references('usergmail')->on('Users')->cascadeOnDelete();
            $table->unique(['user_id','slug']);
            $table->unique(['user_id','name']); // (tuỳ chọn) tránh trùng tên trong 1 user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
