<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $dbName = DB::getDatabaseName();
        $constraints = DB::select(
            "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'thongke' AND COLUMN_NAME = 'user_id' AND REFERENCED_TABLE_NAME IS NOT NULL",
            [$dbName]
        );

        foreach ($constraints as $row) {
            $name = $row->CONSTRAINT_NAME ?? $row->constraint_name ?? null;
            if ($name) {
                DB::statement("ALTER TABLE `thongke` DROP FOREIGN KEY `{$name}`");
            }
        }

        // Index creation skipped (may already exist)
    }

    public function down(): void
    {
        Schema::table('thongke', function (Blueprint $table) {
            // Cannot reliably restore FK due to environment table name differences.
            // Leaving only an index in down method to keep performance.
            // try { $table->dropIndex(['user_id','topic_id']); } catch (\Throwable $e) {}
            // try { $table->foreign('user_id')->references('usergmail')->on('users')->cascadeOnDelete(); } catch (\Throwable $e) {}
        });
    }
};
