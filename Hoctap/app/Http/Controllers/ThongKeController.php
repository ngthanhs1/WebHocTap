<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\ThongKe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    // Lưu 1 bản ghi thống kê khi user nộp bài ôn tập
    public function store(Request $request)
    {
        $data = $request->validate([
            'topic_id'        => ['required','exists:topics,id'],
            'score'           => ['required','integer','min:0'],
            'total_questions' => ['required','integer','min:1'],
            'started_at'      => ['nullable','date'],
            'finished_at'     => ['nullable','date'],
        ]);

        $topic = Topic::findOrFail($data['topic_id']);
        abort_unless($topic->user_id === auth()->id(), 403);

        ThongKe::create([
            'user_id'         => auth()->id(),
            'topic_id'        => $topic->id,
            'score'           => $data['score'],
            'total_questions' => $data['total_questions'],
            'started_at'      => $data['started_at'] ?? now(),
            'finished_at'     => $data['finished_at'] ?? now(),
        ]);

        return back()->with('ok', 'Đã lưu kết quả ôn tập');
    }

    // Trang báo cáo: Tên chủ đề | ID | % đúng | Thời gian tạo | Số lần làm
    public function index()
    {
        $userId = auth()->id();

        $rows = Topic::query()
            ->where('topics.user_id', $userId)
            ->leftJoin('thongke as tk', function ($join) use ($userId) {
                $join->on('tk.topic_id', '=', 'topics.id')
                     ->where('tk.user_id', '=', $userId);
            })
            ->groupBy('topics.id','topics.name','topics.created_at')
            ->orderByDesc('topics.created_at')
            ->get([
                'topics.id',
                'topics.name',
                'topics.created_at',
                DB::raw('COUNT(tk.id) as so_lan_lam'),
                DB::raw('ROUND( (CASE WHEN COALESCE(SUM(tk.total_questions),0)=0 
                                       THEN 0 
                                       ELSE SUM(tk.score)/SUM(tk.total_questions)*100 END), 2 ) as tong_phan_tram_dung')
            ]);

        return view('thongke.index', compact('rows'));
    }
}
