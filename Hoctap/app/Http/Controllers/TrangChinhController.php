<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;

class TrangChinhController extends Controller
{
    /**
     * Hiển thị trang chính của ứng dụng
     */
    public function index()
    {
        // Lấy thông tin user hiện tại
        $user = Auth::user();
        
        // Lấy các chủ đề của user hiện tại với thông tin câu hỏi
        // Sử dụng usergmail thay vì id vì đó là primary key
        $topics = Topic::where('user_id', $user->usergmail)
            ->withCount('questions')
            ->latest()
            ->get();
        
        return view('trangchinh', compact('user', 'topics'));
    }
}