<?php

namespace App\Http\Controllers;

use App\Models\{DeThi, CauHoi};
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CauHoiController extends Controller
{
    public function index(DeThi $de_thi){
        $cauHois = $de_thi->cauHois()->withCount('dapAns')->latest()->paginate(20);
        return view('cauhoi.index', compact('de_thi','cauHois'));
    }
    public function create(DeThi $de_thi){ return view('cauhoi.create', compact('de_thi')); }
    public function store(Request $r, DeThi $de_thi){
        $data = $r->validate([
            'noi_dung'=>'required|string',
            'giai_thich'=>'nullable|string',
            'do_kho'=>'required|in:easy,medium,hard',
            'dap_an'=>'required|array|min:2|max:6',
            'dap_an.*.noi_dung'=>'required|string',
            'dap_an.*.dung'=>'required|boolean',
        ]);
        DB::transaction(function() use ($de_thi,$data){
            $q = $de_thi->cauHois()->create(Arr::only($data,['noi_dung','giai_thich','do_kho']));
            $q->dapAns()->createMany($data['dap_an']);
            if (!$q->dapAns()->where('dung',true)->exists()){
                throw new \RuntimeException('Cần ít nhất 1 đáp án đúng');
            }
        });
        return redirect()->route('de-thi.cau-hoi.index',$de_thi)->with('ok','Đã tạo câu hỏi');
    }
    public function edit(DeThi $de_thi, CauHoi $cau_hoi){ $cau_hoi->load('dapAns'); return view('cauhoi.edit', compact('de_thi','cau_hoi')); }
    public function update(Request $r, DeThi $de_thi, CauHoi $cau_hoi){
        $data = $r->validate([
            'noi_dung'=>'required|string',
            'giai_thich'=>'nullable|string',
            'do_kho'=>'required|in:easy,medium,hard',
        ]);
        $cau_hoi->update($data);
        return redirect()->route('de-thi.cau-hoi.index',$de_thi)->with('ok','Đã cập nhật');
    }
    public function destroy(DeThi $de_thi, CauHoi $cau_hoi){
        $cau_hoi->delete(); return back()->with('ok','Đã xóa');
    }
}
