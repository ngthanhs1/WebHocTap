<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    // Danh sách chủ đề của user hiện tại
    public function index()
    {
        $topics = Topic::where('user_id', auth()->id())
            ->latest()->get();

        return view('topics.index', compact('topics'));
    }

    // Form tạo chủ đề
    public function create()
    {
        // Kiểm tra xem có câu hỏi trong session không
        if (!session('quiz_questions')) {
            return redirect()->route('cauhoi.create')->with('error', 'Vui lòng tạo câu hỏi trước!');
        }
        
        return view('chude');
    }

    // Lưu chủ đề
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255'],
        ]);

        $data['user_id'] = auth()->id();

        $topic = Topic::create($data);

        // Lấy câu hỏi từ session và lưu vào database
        $questions = session('quiz_questions', []);
        foreach ($questions as $questionData) {
            $question = $topic->questions()->create([
                'content' => $questionData['content']
            ]);

            foreach ($questionData['choices'] as $choiceData) {
                $question->choices()->create([
                    'content' => $choiceData['content'],
                    'is_correct' => $choiceData['is_correct']
                ]);
            }
        }

        // Xóa session sau khi lưu
        session()->forget('quiz_questions');

        return redirect()->route('trangchinh')
            ->with('ok', 'Đã tạo chủ đề và câu hỏi thành công!');
    }

    // Xem 1 chủ đề + câu hỏi bên trong
    public function show(Topic $topic)
    {
        abort_unless($topic->user_id === auth()->id(), 403);

        $topic->load('questions.choices');

        return view('topics.show', compact('topic'));
    }

    // Form sửa chủ đề
    public function edit(Topic $topic)
    {
        abort_unless($topic->user_id === auth()->id(), 403);
        
        return view('topics.edit', compact('topic'));
    }

    // Cập nhật chủ đề
    public function update(Request $request, Topic $topic)
    {
        abort_unless($topic->user_id === auth()->id(), 403);

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255'],
        ]);

        $topic->update($data);

        return redirect()->route('trangchinh')
            ->with('ok', 'Đã cập nhật chủ đề thành công!');
    }

    // Xóa chủ đề
    public function destroy(Topic $topic)
    {
        abort_unless($topic->user_id === auth()->id(), 403);

        // Xóa tất cả questions và choices liên quan
        foreach ($topic->questions as $question) {
            $question->choices()->delete();
        }
        $topic->questions()->delete();
        $topic->delete();

        return redirect()->route('trangchinh')
            ->with('ok', 'Đã xóa chủ đề thành công!');
    }
}
