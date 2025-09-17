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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // chủ sở hữu
            $table->string('name');                                         // tên chủ đề
            $table->string('slug');                                         // slug duy nhất theo user
            $table->timestamps();

            $table->unique(['user_id','slug']);
            $table->unique(['user_id','name']); // (tuỳ chọn) tránh trùng tên trong 1 user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
