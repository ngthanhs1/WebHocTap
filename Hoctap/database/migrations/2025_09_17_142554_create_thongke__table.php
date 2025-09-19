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
        Schema::create('thongke', function (Blueprint $table) {
            $table->id();

            // Người làm chủ đề - sử dụng string để tham chiếu đến usergmail
            $table->string('user_id', 50);

            // Chủ đề được làm
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();

            // Số câu đúng
            $table->integer('score')->default(0);

            // Tổng số câu
            $table->integer('total_questions')->default(0);

            // Thời gian bắt đầu / kết thúc
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->timestamps();

            // Tạo foreign key constraint cho user_id
            $table->foreign('user_id')->references('usergmail')->on('users')->cascadeOnDelete();
            $table->index(['user_id','topic_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thongke');
    }
};
