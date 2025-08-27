<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('mon_hocs', function (Blueprint $table) {
            $table->id();
            $table->string('ten')->unique();    // Tên môn học
            $table->text('mo_ta')->nullable();  // Mô tả môn học (có thể để trống)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('mon_hocs');
    }
};
