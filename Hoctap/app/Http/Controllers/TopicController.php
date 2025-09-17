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
        return view('topics.create');
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

        return redirect()->route('topics.show', $topic)
            ->with('ok', 'Đã tạo chủ đề');
    }

    // Xem 1 chủ đề + câu hỏi bên trong
    public function show(Topic $topic)
    {
        abort_unless($topic->user_id === auth()->id(), 403);

        $topic->load('questions.choices');

        return view('topics.show', compact('topic'));
    }
}
