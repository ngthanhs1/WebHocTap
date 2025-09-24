<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Hiển thị trang tạo câu hỏi
    public function create()
    {
        return view('cauhoi');
    }

    // Lưu danh sách câu hỏi vào session
    public function saveToSession(Request $request)
    {
        $questions = $request->input('questions', []);
        session(['quiz_questions' => $questions]);
        
        return response()->json(['success' => true]);
    }

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

    // Hiển thị 1 câu hỏi với các đáp án
    public function show(Question $question)
    {
        abort_unless($question->topic->user_id === auth()->id(), 403);
        
        $question->load('choices');
        return view('questions.show', compact('question'));
    }

    // Form sửa câu hỏi
    public function edit(Question $question)
    {
        abort_unless($question->topic->user_id === auth()->id(), 403);
        
        $question->load('choices');
        return view('questions.edit', compact('question'));
    }

    // Cập nhật câu hỏi
    public function update(Request $request, Question $question)
    {
        abort_unless($question->topic->user_id === auth()->id(), 403);

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

        // Cập nhật câu hỏi
        $question->update(['content' => $data['content']]);

        // Xóa các đáp án cũ và tạo mới
        $question->choices()->delete();
        foreach ($data['choices'] as $c) {
            $question->choices()->create([
                'content'    => $c['content'],
                'is_correct' => (bool) $c['is_correct'],
            ]);
        }

        return redirect()->route('topics.show', $question->topic)
            ->with('ok', 'Đã cập nhật câu hỏi thành công!');
    }

    // Xóa câu hỏi
    public function destroy(Question $question)
    {
        abort_unless($question->topic->user_id === auth()->id(), 403);

        $topic = $question->topic;
        $question->choices()->delete();
        $question->delete();

        return redirect()->route('topics.show', $topic)
            ->with('ok', 'Đã xóa câu hỏi thành công!');
    }
}
