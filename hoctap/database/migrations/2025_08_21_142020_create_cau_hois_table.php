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
        Schema::create('cau_hois', function (Blueprint $table) {
            $table->id();
            $table->foreignId('de_thi_id')->constrained('de_this')->cascadeOnDelete(); 
            $table->text('noi_dung');                  // nội dung câu hỏi
            $table->text('giai_thich')->nullable();    // giải thích (tùy chọn)
            $table->string('do_kho')->default('easy'); // mức độ khó: easy/medium/hard
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cau_hois');
    }
};
