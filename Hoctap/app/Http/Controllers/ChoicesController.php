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

    // Cập nhật đáp án
    public function update(Request $request, $choiceId)
    {
        $choice = \App\Models\Choice::findOrFail($choiceId);
        
        // bảo vệ: chỉ cập nhật đáp án thuộc câu hỏi của user
        $choice->load('question.topic');
        abort_unless($choice->question->topic->user_id === auth()->id(), 403);

        $data = $request->validate([
            'content'    => ['required','string'],
            'is_correct' => ['required','boolean'],
        ]);

        // nếu đánh dấu đúng → đảm bảo các đáp án khác đều là false
        if ($data['is_correct']) {
            $choice->question->choices()->where('id', '!=', $choice->id)->update(['is_correct' => false]);
        }

        $choice->update($data);

        return back()->with('ok', 'Đã cập nhật đáp án');
    }

    // Xóa đáp án
    public function destroy($choiceId)
    {
        $choice = \App\Models\Choice::findOrFail($choiceId);
        
        // bảo vệ: chỉ xóa đáp án thuộc câu hỏi của user
        $choice->load('question.topic');
        abort_unless($choice->question->topic->user_id === auth()->id(), 403);

        // Không cho xóa nếu chỉ còn 2 đáp án
        if ($choice->question->choices()->count() <= 2) {
            return back()->withErrors(['error' => 'Mỗi câu hỏi phải có ít nhất 2 đáp án']);
        }

        $choice->delete();

        return back()->with('ok', 'Đã xóa đáp án');
    }
}
