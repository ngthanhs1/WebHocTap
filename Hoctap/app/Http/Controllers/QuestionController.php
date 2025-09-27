<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Hiển thị trang tạo câu hỏi
    public function create(Request $request)
    {
        // Nếu có topic_id, hiển thị form thêm câu hỏi cho chủ đề đó
        if ($request->has('topic_id')) {
            $topic = Topic::where('id', $request->topic_id)
                         ->where('user_id', auth()->user()->usergmail)
                         ->firstOrFail();
            return view('questions.create', compact('topic'));
        }
        
        // Nếu không có topic_id, hiển thị trang tạo câu hỏi thông thường
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
        abort_unless($topic->user_id === auth()->user()->usergmail, 403);

        $data = $request->validate([
            'content' => ['required','string','max:500'],
            'choices' => ['required','array'],
            'choices.*.content' => ['nullable','string','max:200'],
            'choices.*.is_correct' => ['required','boolean'],
            'correct_choice' => ['required','integer','min:0','max:3']
        ]);

        // Lọc các đáp án có nội dung
        $validChoices = [];
        foreach ($data['choices'] as $index => $choice) {
            if (!empty(trim($choice['content'] ?? ''))) {
                $validChoices[] = [
                    'content' => trim($choice['content']),
                    'is_correct' => ($index == $data['correct_choice'])
                ];
            }
        }

        // Kiểm tra tối thiểu 2 đáp án
        if (count($validChoices) < 2) {
            return back()->withErrors(['choices' => 'Cần ít nhất 2 đáp án có nội dung.'])
                         ->withInput();
        }

        // Kiểm tra đáp án đúng có nội dung
        $correctChoiceContent = $data['choices'][$data['correct_choice']]['content'] ?? '';
        if (empty(trim($correctChoiceContent))) {
            return back()->withErrors(['correct_choice' => 'Đáp án được chọn làm đáp án đúng phải có nội dung.'])
                         ->withInput();
        }

        try {
            // Tạo câu hỏi
            $question = $topic->questions()->create([
                'content' => $data['content'],
            ]);

            // Tạo đáp án
            foreach ($validChoices as $choice) {
                $question->choices()->create([
                    'content' => $choice['content'],
                    'is_correct' => $choice['is_correct'],
                ]);
            }

            return redirect()->route('topics.show', $topic)
                           ->with('success', 'Đã thêm câu hỏi thành công!');
                           
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra khi lưu câu hỏi: ' . $e->getMessage()])
                         ->withInput();
        }
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
