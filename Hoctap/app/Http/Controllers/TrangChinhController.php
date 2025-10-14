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
    public function index(Request $request)
    {
        // Lấy thông tin user hiện tại
        $user = Auth::user();
        $sort = $request->get('sort', 'created_desc');
        
        // Lấy các chủ đề của user hiện tại với thông tin câu hỏi
        // Sử dụng usergmail thay vì id vì đó là primary key
        $topicsQuery = Topic::where('user_id', $user->usergmail)
            ->withCount('questions');

        // Sắp xếp theo lựa chọn
        switch ($sort) {
            case 'name_asc':
                $topicsQuery->orderBy('name', 'asc');
                break;
            case 'updated_desc':
                $topicsQuery->orderBy('updated_at', 'desc');
                break;
            case 'created_asc':
                $topicsQuery->orderBy('created_at', 'asc');
                break;
            case 'created_desc':
            default:
                $topicsQuery->orderBy('created_at', 'desc');
                break;
        }

        $topics = $topicsQuery->get();
        
        return view('trangchinh', compact('user', 'topics'));
    }
}