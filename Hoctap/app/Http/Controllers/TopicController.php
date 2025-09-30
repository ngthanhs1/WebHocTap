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

    // Lưu chủ đề (lấy từ session)
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255'],
        ]);

        // Tạo slug nếu chưa có
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }

        // Tạo chủ đề
        $topic = Topic::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'user_id' => auth()->user()->usergmail,
        ]);

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
            ->with('success', 'Đã tạo chủ đề và câu hỏi thành công!');
    }

    // Hiển thị danh sách chủ đề để chọn thêm câu hỏi
    public function selectForQuestions()
    {
        $topics = Topic::where('user_id', auth()->user()->usergmail)
                      ->withCount('questions')
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        return view('topics.select', compact('topics'));
    }

    // Thêm câu hỏi vào chủ đề đã có
    public function addQuestions(Topic $topic)
    {
        // Lấy câu hỏi từ session và lưu vào chủ đề hiện tại
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
            ->with('success', 'Đã thêm câu hỏi vào chủ đề thành công!');
    }

    // Xem 1 chủ đề + câu hỏi bên trong
    public function show(Topic $topic)
    {
        abort_unless($topic->user_id === auth()->user()->usergmail, 403);

        $topic->load('questions.choices');

        return view('topics.show', compact('topic'));
    }

    // Form sửa chủ đề
    public function edit(Topic $topic)
    {
        abort_unless($topic->user_id === auth()->user()->usergmail, 403);
        
        return view('topics.edit', compact('topic'));
    }

    // Cập nhật chủ đề
    public function update(Request $request, Topic $topic)
    {
        abort_unless($topic->user_id === auth()->user()->usergmail, 403);

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
        abort_unless($topic->user_id === auth()->user()->usergmail, 403);

        // Xóa tất cả questions và choices liên quan
        foreach ($topic->questions as $question) {
            $question->choices()->delete();
        }
        $topic->questions()->delete();
        $topic->delete();

        return redirect()->route('trangchinh')
            ->with('ok', 'Đã xóa chủ đề thành công!');
    }

    // Study mode - hiển thị câu hỏi với đáp án để ôn tập
    public function study(Topic $topic)
    {
        abort_unless($topic->user_id === auth()->user()->usergmail, 403);

        $topic->load('questions.choices');

        return view('topics.study', compact('topic'));
    }

    // Test mode - bài kiểm tra không hiện đáp án
    public function test(Topic $topic)
    {
        abort_unless($topic->user_id === auth()->user()->usergmail, 403);

        $topic->load('questions.choices');

        return view('topics.test', compact('topic'));
    }

    // Xử lý kết quả test
    public function testSubmit(Request $request, Topic $topic)
    {
        abort_unless($topic->user_id === auth()->user()->usergmail, 403);

        $userAnswers = $request->input('answers', []);
        $questions = $topic->questions()->with('choices')->get();
        
        $score = 0;
        $total = $questions->count();
        $results = [];

        foreach ($questions as $question) {
            $correctChoice = $question->choices->where('is_correct', true)->first();
            $userChoiceId = $userAnswers[$question->id] ?? null;
            
            $isCorrect = $userChoiceId && $userChoiceId == $correctChoice->id;
            
            if ($isCorrect) {
                $score++;
            }

            $results[] = [
                'question' => $question,
                'user_choice_id' => $userChoiceId,
                'correct_choice_id' => $correctChoice->id,
                'is_correct' => $isCorrect
            ];
        }

        $percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;

        return view('topics.test-result', compact('topic', 'results', 'score', 'total', 'percentage'));
    }
}
