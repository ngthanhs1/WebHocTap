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
        // Tìm user admin đã có hoặc tạo mới
        $user = User::firstOrCreate(
            ['usergmail' => 'hihi@gmail.com'],
            [
                'username' => 'hihi',
                'password' => bcrypt('123456')
            ]
        );

        // Tạo 1 chủ đề cho admin
        $topic = Topic::updateOrCreate(
            [
                'user_id' => $user->usergmail,
                'name'    => 'Toán cơ bản',
            ],
            [
                'slug'    => 'toan-co-ban',
            ]
        );

        // Thêm 1 câu hỏi cho chủ đề
        $question = $topic->questions()->firstOrCreate(
            ['content' => '2 + 2 = ?']
        );

        // Xóa các choices cũ và tạo mới
        $question->choices()->delete();
        $question->choices()->createMany([
            ['content' => '3', 'is_correct' => false],
            ['content' => '4', 'is_correct' => true],
            ['content' => '5', 'is_correct' => false],
            ['content' => '6', 'is_correct' => false],
        ]);

        // Thêm 1 bản ghi thống kê
        ThongKe::updateOrCreate(
            [
                'user_id'  => $user->usergmail,
                'topic_id' => $topic->id,
            ],
            [
                'score'           => 7,
                'total_questions' => 10,
                'started_at'      => now(),
                'finished_at'     => now(),
            ]
        );
    }
}
