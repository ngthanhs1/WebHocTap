<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class ChoicesController extends Controller
{
    public function store(Request $request, Question $question)
    {
        // bảo vệ: chỉ thêm vào câu hỏi thuộc topic của chính user
        $question->load('topic');
        abort_unless($question->topic->user_id === auth()->id(), 403);

        $data = $request->validate([
            'content'    => ['required','string'],
            'is_correct' => ['required','boolean'],
        ]);

        // nếu đánh dấu đúng → đảm bảo các đáp án khác đều là false
        if ($data['is_correct']) {
            $question->choices()->update(['is_correct' => false]);
        }

        $question->choices()->create($data);

        return back()->with('ok', 'Đã thêm đáp án');
    }
}
