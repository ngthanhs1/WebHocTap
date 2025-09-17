<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Topic;
use App\Models\Question;
use App\Models\Choice;
use App\Models\ThongKe;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo 1 user test
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
        ]);

        // Tạo 1 chủ đề
        $topic = Topic::create([
            'user_id' => $user->id,
            'name'    => 'Toán cơ bản',
            'slug'    => 'toan-co-ban',
        ]);

        // Thêm 1 câu hỏi
        $question = $topic->questions()->create([
            'content' => '2 + 2 = ?',
        ]);

        // Thêm các đáp án cho câu hỏi
        $question->choices()->createMany([
            ['content' => '3', 'is_correct' => false],
            ['content' => '4', 'is_correct' => true],
            ['content' => '5', 'is_correct' => false],
        ]);

        // Thêm 1 bản ghi thống kê (giả sử user làm đúng 7/10 câu)
        ThongKe::create([
            'user_id'         => $user->id,
            'topic_id'        => $topic->id,
            'score'           => 7,
            'total_questions' => 10,
            'started_at'      => now(),
            'finished_at'     => now(),
        ]);
    }
}
