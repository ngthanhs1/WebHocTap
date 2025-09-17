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
        Schema::create('choices', function (Blueprint $table) {
            $table->id();

            // Câu hỏi mà đáp án thuộc về
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();

            // Nội dung đáp án
            $table->longText('content');

            // Đúng hay sai: 1 = đúng, 0 = sai
            $table->boolean('is_correct')->default(false);

            $table->timestamps();

            // Index để tìm nhanh theo câu hỏi
            $table->index('question_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('choices');
    }
};
