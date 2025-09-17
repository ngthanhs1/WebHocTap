<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Thêm 1 câu hỏi + nhiều đáp án vào topic
    public function store(Request $request, Topic $topic)
    {
        abort_unless($topic->user_id === auth()->id(), 403);

        $data = $request->validate([
            'content' => ['required','string'],
            'choices' => ['required','array','min:2'],
            'choices.*.content'    => ['required','string'],
            'choices.*.is_correct' => ['required','boolean'],
        ]);

        // phải có đúng 1 đáp án đúng
        $correctCount = collect($data['choices'])->where('is_correct', true)->count();
        if ($correctCount !== 1) {
            return back()->withErrors(['choices' => 'Mỗi câu hỏi phải có đúng 1 đáp án đúng.'])
                         ->withInput();
        }

        // tạo câu hỏi
        $question = $topic->questions()->create([
            'content' => $data['content'],
        ]);

        // tạo đáp án
        foreach ($data['choices'] as $c) {
            $question->choices()->create([
                'content'    => $c['content'],
                'is_correct' => (bool) $c['is_correct'],
            ]);
        }

        return back()->with('ok', 'Đã thêm câu hỏi & đáp án');
    }
}
