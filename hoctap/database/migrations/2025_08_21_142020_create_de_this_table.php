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
        Schema::create('de_this', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mon_hoc_id')->constrained('mon_hocs')->cascadeOnDelete(); 
            $table->string('tieu_de');           // tiêu đề đề thi
            $table->text('mo_ta')->nullable();   // mô tả ngắn gọn
            $table->boolean('cong_khai')->default(false); // trạng thái công khai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('de_this');
    }
};
